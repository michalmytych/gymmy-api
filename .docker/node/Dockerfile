FROM node:alpine as node

WORKDIR /app

RUN set -eux; \
    npm install --no-optional; \
    npm run dev; \
