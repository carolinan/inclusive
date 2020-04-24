module.exports = {
	plugins: {
		autoprefixer: {}
	}
};

module.exports = {
	plugins: [
		require('cssnano')({
			preset: 'default',
		}),
	],
};
