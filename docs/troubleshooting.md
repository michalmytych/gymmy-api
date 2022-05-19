# Troubleshooting

## Permissions
Most popular error with docker, due to isnde-container permissions:
```bash
There is no existing directory at .../storage/logs and it cannot be created: Permission denied
```
To solve it, just run:
```bash
php artisan optimize:clear
```
