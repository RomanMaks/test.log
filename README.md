# test.log

## Соответствие версий ПО 

- Vagrant https://www.vagrantup.com/ 
- Vagrant ver 2.2.4

- Virtualbox https://www.virtualbox.org/
- Virtualbox ver 5.2.22

- Git https://git-scm.com/
- Git ver Windows 2.21.0

## Настройки локального окружения

Поднимите виртуальную машину командой `vagrant up --provision`
- Зайдите в ВМ `vagrant ssh`, перейдите в папку `~/code`
- Соберите приложение командой `php vendor/phing/phing/bin/phing -f ./build/dev/build.xml`

- Заходите на http://dev.log.local/
