const { createProxyMiddleware } = require('http-proxy-middleware');

module.exports = (app) => {
  //departments/list
  app.use(
    '/departments/list',
    createProxyMiddleware({
      target: 'http://127.0.0.1:8000',
      changeOrigin: true,
    })
  );

  //enrollments/create
  app.use(
    '/enrollments/create',
    createProxyMiddleware({
      target: 'http://127.0.0.1:8000',
      changeOrigin: true,
      secure: false,
    })
  );
};
