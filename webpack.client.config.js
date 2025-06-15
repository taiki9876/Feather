const path = require("path");

module.exports = {
  entry: "./frontend/src/app.tsx",
  mode: "development",
  devtool: "source-map",
  output: {
    path: path.resolve(__dirname, "public/js"),
    filename: "app.js",
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
      {
        test: /\.css$/,
        use: ["style-loader", "css-loader"],
      },
    ],
  },
};
