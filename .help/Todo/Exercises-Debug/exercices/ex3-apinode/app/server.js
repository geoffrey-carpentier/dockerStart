// Exercice 3 - ApiNode : application minimale
// Cette API repond simplement pour prouver que le conteneur tourne.
const http = require('http');

const server = http.createServer((req, res) => {
  res.writeHead(200, { 'Content-Type': 'text/plain; charset=utf-8' });
  res.end('ApiNode : le service Node fonctionne correctement.\n');
});

server.listen(3000, () => {
  console.log('ApiNode a l ecoute sur le port 3000');
});
