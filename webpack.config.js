const path = require("path");
const nodeExternals = require("webpack-node-externals");

module.exports = {
  entry: "./frontend/src/ssr-server.ts",
  target: "node",
  externals: [nodeExternals()],
  output: {
    path: path.resolve(__dirname, "dist"),
    filename: "ssr-server.js",
  },
  resolve: {
    extensions: [".ts", ".tsx", ".js", ".jsx"],
  },
  module: {
    rules: [
      {
        test: /\.tsx?$/,
        use: "ts-loader",
        exclude: /node_modules/,
      },
    ],
  },
};
