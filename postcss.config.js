module.exports = {
	plugins: {
		autoprefixer: {}
	}
};

module.exports = {
	plugins: [
		require('postcss-preset-env')({
			preserve: true,
			importFrom: 'assets/css/variables.css'
		}),
		require('cssnano')({
			preset: 'default',
		}),
		require('postcss-custom-media')({
			importFrom: 'assets/css/variables.css'
		}),
	],
};
