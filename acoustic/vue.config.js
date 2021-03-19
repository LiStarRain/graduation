module.exports = {
  devServer: {
    proxy: {
      '/api': {
        target: 'http://localhost:8888',
        // 允许跨域
        changeOrigin: true,
        ws: true,
        pathRewrite: {
          '^/api': ''
        }
      }
    }
  }
}