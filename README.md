# ICELAND
AWS Develoment Discovery

##### Git commands
* git remote add origin https://github.com/StellaNova1604/ICELAND.git
* git push -u origin master
 or
* git clone https://github.com/StellaNova1604/ICELAND.git
* git pull origin

## Allegro
AWS/Payara Playground

##### Maven commands
* mvn -B archetype:generate -DarchetypeArtifactId=maven-archetype-webapp -DgroupId=net.robotmodel67.discovery -DartifactId=Allegro

* Solve ssl/firewall issue edit settings.xml file
```xml
    <mirror>
        <id>central-no-ssl</id>
        <name>Central without ssl</name>
        <url>http://repo.maven.apache.org/maven2</url>
        <mirrorOf>central</mirrorOf>
    </mirror>
```

## Avignon
AWS/Wildfly-Swarn Playground

* mvn -B archetype:generate -DarchetypeArtifactId=maven-archetype-webapp -DgroupId=net.robotmodel67.discovery -DartifactId=Avignon
* mvn wildfly-swarm:run

2018-07-16
https://www.microsoft.com/net/learn/apps/machine-learning-and-ai/ml-dotnet

Editar el archivo \api\v1\certificado.php

Reemplazar todas las ocurrencias de:

$this->mail->setFrom('robotmodel67@gmail.com', 'ATLAS a un click!');

por

$this->mail->setFrom($settings['correo_notificacion'];, 'ATLAS a un click!');

Y volvemos a prbar
