const http = require('http');

const server = http.createServer((req, res) => {
  res.writeHead(200, { 'Content-Type': 'text/plain' });
  res.end('Node.js server is running!\n');
});

server.listen(3000, () => {
  console.log('Server is listening on port 3000');
});