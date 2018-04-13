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
