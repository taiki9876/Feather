# Makefile for Mini Framework

# Variables
SASS_INPUT = frontend/scss/app.scss
CSS_OUTPUT = public/css/app.css
CSS_OUTPUT_MIN = public/css/app.min.css

# Default target
.PHONY: help
help:
	@echo "Available commands:"
	@echo "  make install       - Install dependencies"
	@echo "  make build-css     - Build CSS from Sass"
	@echo "  make watch-css     - Watch Sass files and auto-build"
	@echo "  make serve         - Start PHP development server"
	@echo "  make clean         - Clean generated files"
	@echo "  make usecase NAME=<name> - Create new UseCase"

# Install dependencies
.PHONY: install
install:
	composer install
	npm install

# Build CSS from Sass
.PHONY: build-css
build-css:
	@echo "Building CSS from Sass..."
	@mkdir -p public/css
	npx sass $(SASS_INPUT) $(CSS_OUTPUT) --style=expanded
	npx sass $(SASS_INPUT) $(CSS_OUTPUT_MIN) --style=compressed
	@echo "CSS build completed!"

# Watch Sass files and auto-build
.PHONY: watch-css
watch-css:
	@echo "Watching Sass files for changes..."
	npx sass --watch $(SASS_INPUT):$(CSS_OUTPUT) --style=expanded

# Start PHP development server
.PHONY: serve
serve:
	@echo "Starting PHP development server..."
	php -S localhost:8000 -t public

# Clean generated files
.PHONY: clean
clean:
	@echo "Cleaning generated files..."
	rm -rf public/css/*.css
	rm -rf vendor/
	rm -rf node_modules/
	@echo "Clean completed!"

# Create new UseCase
.PHONY: usecase
usecase:
	@if [ -z "$(NAME)" ]; then \
		echo "Usage: make usecase NAME=<UseCaseName>"; \
		echo "Example: make usecase NAME=CreateUser"; \
		exit 1; \
	fi
	php scripts/make-usecase.php $(NAME)

# Development workflow
.PHONY: dev
dev: install build-css serve

# Production build
.PHONY: build
build: install build-css
	@echo "Production build completed!" 