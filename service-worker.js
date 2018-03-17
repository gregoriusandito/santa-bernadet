/*
Copyright 2016 Google Inc.
Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at
    http://www.apache.org/licenses/LICENSE-2.0
Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/

(function() {
  'use strict';

  // TODO 2 - cache the application shell
    var filesToCache = [
      '.',
      'assets/home/css/main.css',
      'assets/home/css/custom.css',
      'assets/home/css/bootstrap.min.css',
      'assets/home/css/font-awesome.min.css',
      'assets/home/js/main.js',
      'https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700',
      'https://fonts.googleapis.com/css?family=Oswald:400,300,700',
      'https://fonts.googleapis.com/css?family=PT+Serif:400,400italic,700,700italic',
      'https://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700',
      'https://fonts.googleapis.com/css?family=Roboto:400,300',
      'https://fonts.googleapis.com/css?family=Hind|Playfair+Display',      
      'uploads/company/banner-web 1.png',
      'uploads/company/index.jpg',
      'uploads/company/logo.png',
      'assets/home/img/logo/logo-optimized.png',
      'sw-modules/offline.html',
      'sw-modules/404.html'
    
    ];
    
    var staticCacheName = 'pages-cache-v1';
    
    self.addEventListener('install', function(event) {
      console.log('Attempting to install service worker and cache static assets');
      event.waitUntil(
        caches.open(staticCacheName)
        .then(function(cache) {
          return cache.addAll(filesToCache);
        })
      );
    });  

    self.addEventListener('fetch', function(event) {
      console.log('Fetch event for ', event.request.url);
      event.respondWith(
        caches.match(event.request).then(function(response) {
          if (response) {
            console.log('Found ', event.request.url, ' in cache');
            return response;
          }
          console.log('Network request for ', event.request.url);
          return fetch(event.request)
    
          // TODO 4 - Add fetched files to the cache
            .then(function(response) {
            
              // TODO 5 - Respond with custom 404 page
              if (response.status === 404) {
                return caches.match('sw-modules/404.html');
              }              
            
              return caches.open(staticCacheName).then(function(cache) {
                if (event.request.url.indexOf('test') < 0) {
                  cache.put(event.request.url, response.clone());
                }
                return response;
              });
            });          
    
        }).catch(function(error) {
          // TODO 6 - Respond with custom offline page
            console.log('Error, ', error);
            return caches.match('sw-modules/offline.html');
        })
      );
    });

  // TODO 7 - delete unused caches
    // self.addEventListener('activate', function(event) {
    //   console.log('Activating new service worker...');
    
    //   var cacheWhitelist = [staticCacheName];
    
    //   event.waitUntil(
    //     caches.keys().then(function(cacheNames) {
    //       return Promise.all(
    //         cacheNames.map(function(cacheName) {
    //           if (cacheWhitelist.indexOf(cacheName) === -1) {
    //             return caches.delete(cacheName);
    //           }
    //         })
    //       );
    //     })
    //   );
    // });
})();