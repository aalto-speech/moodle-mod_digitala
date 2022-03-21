FROM node:17-buster

WORKDIR /api

COPY package.json package-lock.json ./

RUN npm ci

EXPOSE 3000

COPY . .

CMD ["node","index.js"]