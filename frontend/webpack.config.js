const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');

module.exports = {
    mode: 'development', // Đổi thành 'production' khi build cho môi trường sản xuất

    entry: './src/index.js', // Đảm bảo đường dẫn này đúng với điểm vào của bạn

    output: {
        path: path.resolve(__dirname, 'dist'), // Đường dẫn tới thư mục build
        filename: 'bundle.js', // Tên tệp JS đã được bundling
        publicPath: '/', // Đảm bảo tài nguyên được load đúng cách
    },

    module: {
        rules: [
            {
                test: /\.js$/, // Áp dụng cho tất cả các tệp JavaScript
                exclude: /node_modules/, // Không xử lý thư mục node_modules
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env', '@babel/preset-react'], // Sử dụng Babel để biên dịch JS và JSX
                    },
                },
            },
            {
                test: /\.css$/, // Áp dụng cho các tệp CSS
                use: ['style-loader', 'css-loader'], // Tải CSS và chèn vào trong DOM
            },
            {
                test: /\.(png|jpe?g|gif|svg)$/, // Áp dụng cho các tệp hình ảnh
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '[name].[hash].[ext]', // Tên tệp hình ảnh sau khi được xử lý
                            outputPath: 'images/', // Đường dẫn xuất ra cho hình ảnh
                        },
                    },
                ],
            },
        ],
    },

    plugins: [
        new HtmlWebpackPlugin({
            template: './public/index.html', // Chỉ định tệp HTML mẫu
            favicon: './public/favicon.ico', // Chỉ định favicon (nếu có)
        }),
    ],

    devServer: {
        static: {
          directory: path.join(__dirname, 'public'), 
        },
        compress: true, 
        port: 3000, 
        open: true, 
        historyApiFallback: true,
        watchFiles: {
          paths: ['src/**/*'],
          options: {
            usePolling: true, 
          },
        },
        allowedHosts: 'all',
    },

    devtool: 'source-map',
};
