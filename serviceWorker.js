/*
    Copyright 2016 Google Inc. All Rights Reserved.
   Licenciado sob a Licença Apache, Versão 2.0 (a "Licença");
     você não pode usar este arquivo, exceto em conformidade com a Licença.
     Você pode obter uma cópia da Licença em
     http://www.apache.org/licenses/LICENSE-2.0
     A menos que exigido pela lei aplicável ou acordado por escrito, o software
     distribuído sob a Licença é distribuído "COMO ESTÁ",
     SEM GARANTIAS OU CONDIÇÕES DE QUALQUER TIPO, expressas ou implícitas.
     Consulte a Licença para obter as permissões de controle do idioma específico e
     limitações sob a Licença.
 */

// Nomes dos dois caches usados nesta versão do service worker.
// Mude para v2, etc. quando você atualizar qualquer um dos recursos locais, o que irá
// por sua vez, aciona o evento de instalação novamente.
const PRECACHE = 'precache-v1';
const RUNTIME = 'runtime';
//tst
// Uma lista de recursos locais que sempre queremos armazenar em cache.
const PRECACHE_URLS = [
    // 'path_do_seu_arquivo_cache.css'
    //   './', // Alias for index.html
      'index.html',
      'painel.html',
      'emprestimo.html',
      'painel_consulta.html',
      'style.css',
      'painel.css',
    //   'demo.js'
];

// O manipulador de instalação cuida do pré-caching dos recursos que sempre precisamos.
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(PRECACHE)
            .then(cache => cache.addAll(PRECACHE_URLS))
            .then(self.skipWaiting())
    );
});


// O manipulador de ativação cuida da limpeza de caches antigos.
self.addEventListener('activate', event => {
    const currentCaches = [PRECACHE, RUNTIME];
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return cacheNames.filter(cacheName => !currentCaches.includes(cacheName));
        }).then(cachesToDelete => {
            return Promise.all(cachesToDelete.map(cacheToDelete => {
                return caches.delete(cacheToDelete);
            }));
        }).then(() => self.clients.claim())
    );
});

// O manipulador ( fetch)de busca fornece respostas para recursos de mesma origem de um cache.
// Se nenhuma resposta for encontrada, ele preenche o cache de tempo de execução com a resposta
// da rede antes de retorná-lo à página.
self.addEventListener('fetch', event => {
    // Ignore solicitações de origem cruzada, como as do Google Analytics.
    if (event.request.method === "POST") {
    }
    else {
        if (event.request.url.startsWith(self.location.origin)) {
            event.respondWith(
                caches.match(event.request).then(cachedResponse => {
                    if (cachedResponse) {
                        return cachedResponse;
                    }

                    return caches.open(RUNTIME).then(cache => {
                        return fetch(event.request).then(response => {
                           // Coloca uma cópia da resposta no cache de tempo de execução.
                            return cache.put(event.request, response.clone()).then(() => {
                                return response;
                            });
                        });
                    });
                })
            );
        }
    }
});