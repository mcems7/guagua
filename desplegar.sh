git mv comun/config.php comun/config-ejemplo.php
mv /home/ubuntu/workspace/phpmyadmin /home/ubuntu/phpmyadmin
mv /home/ubuntu/workspace/datos /home/ubuntu/datos
mv /home/ubuntu/workspace/ignorar /home/ubuntu/ignorar
git init
git remote add origin git@github.com:guaguasga/guagua.git
git add .
git commit -m "First commit"
git pull origin master
git push -f origin master
git mv comun/config-ejemplo.php comun/config.php
mv /home/ubuntu/phpmyadmin /home/ubuntu/workspace/phpmyadmin
mv /home/ubuntu/datos /home/ubuntu/workspace/datos
mv /home/ubuntu/ignorar /home/ubuntu/workspace/ignorar