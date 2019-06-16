const path = require("path");
const ExtractTextPlugin = require("extract-text-webpack-plugin");
module.exports = {
    entry: {
        "bundle.min.css": [
            path.resolve(__dirname, "resources/css/style.css")
        ]
    },
    output: {
        filename: "[name]",
        path: path.resolve(__dirname, "dist")
    },
    module: {
        rules: [
            {
                test: /\.css$/,
                use: ExtractTextPlugin.extract({
                    fallback: "style-loader",
                    use: "css-loader"
                })
            }
        ]
    },
    plugins: [
        new ExtractTextPlugin("bundle.min.css")
    ]
}
