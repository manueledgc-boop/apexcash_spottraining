# ApexCash Spot Training - actualización

Cambios incluidos:

- ThreeBetVsOpenSpots.php ampliado de 6 a 25 spots.
- Nuevo módulo SbVsBtnSpots.php con 25 spots.
- Nuevo módulo BbVsSbSpots.php con 25 spots.
- SpotRepository.php actualizado para cargar los nuevos módulos.
- SpotTrainingService.php actualizado con etiquetas de módulos para leaks.
- resources/views/spot-training/index.blade.php actualizado con filtros nuevos.

Resultado esperado:

- Open Raise: 25
- BTN vs 3Bet: 25
- BB vs BTN: 25
- 3Bet vs Open: 25
- SB vs BTN: 25
- BB vs SB: 25
- Total: 150 spots

Verificación realizada:

php -l OK en archivos modificados.
php artisan route:list --path=spot-training OK.
Conteo del repositorio: 150 spots.
