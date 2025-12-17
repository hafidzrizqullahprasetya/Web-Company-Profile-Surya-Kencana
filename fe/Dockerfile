# Build stage
FROM node:20-alpine AS builder

WORKDIR /app

# Copy package files
COPY package*.json ./

# Install dependencies
RUN npm ci

# Copy source code
COPY . .

# Set environment variables for build
ENV VITE_API_BASE_URL=https://becompro.fizualstd.my.id/api
ENV VITE_CDN_URL=https://cdn.fizualstd.my.id
ENV VITE_GOOGLE_MAPS_API_KEY=AIzaSyB1CN8gr_lJkl_sxKSz-JsTuPytFopzoD8

# Build the application
RUN npm run build

# Production stage
FROM nginx:alpine

# Copy built files
COPY --from=builder /app/dist /usr/share/nginx/html

# Copy nginx config
COPY nginx.conf /etc/nginx/conf.d/default.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
