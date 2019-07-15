# test.log

## Соответствие версий ПО 

- Vagrant https://www.vagrantup.com/ 
- Vagrant ver 2.2.4

- Virtualbox https://www.virtualbox.org/
- Virtualbox ver 5.2.22

- Git https://git-scm.com/
- Git ver Windows 2.21.0

## Настройки локального окружения

1. Выполнить команду `composer install`
2. В файле `Homestead.yaml` заменить `folders: - map: /home/workman04/work/TEST/test.log` на свой путь к каталогу `test.log` 
3. Поднимите виртуальную машину командой `vagrant up --provision`
4. Зайдите в ВМ `vagrant ssh`, перейдите в папку `~/code`
5. Соберите приложение командой `php vendor/phing/phing/bin/phing -f ./build/dev/build.xml`

- Заходите на http://dev.log.local/
