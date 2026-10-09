#!/bin/sh
set -e

echo "Waiting for MinIO server to be healthy..."
until /usr/bin/mc alias set myminio http://minio:9000 "${MINIO_ROOT_USER:-learnify_admin}" "${MINIO_ROOT_PASSWORD:-learnify_secret_password}" 2>/dev/null; do
    echo "MinIO not ready yet. Retrying in 2 seconds..."
    sleep 2
done

echo "MinIO is ready. Creating buckets..."

/usr/bin/mc mb --ignore-existing myminio/lms-public
/usr/bin/mc mb --ignore-existing myminio/lms-private
/usr/bin/mc mb --ignore-existing myminio/lms-videos

echo "Setting public download policy for lms-public..."
/usr/bin/mc anonymous set download myminio/lms-public

echo "Listing MinIO buckets:"
/usr/bin/mc ls myminio

echo "MinIO bucket initialization completed successfully."
exit 0
