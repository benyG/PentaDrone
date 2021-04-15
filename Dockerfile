FROM eyesopsec/pentadrone

LABEL Description="PowerShell Post-exploitation agent based on Mitre Att&ck framework" \
	License="Apache License 2.0" \
	Usage="docker run -d -p 80:80 --name pentadrone -v web_data:/var/www/html -v db_data:/var/lib/mysql eyesopsec/pentadrone" \
	Version="1.0"

#RUN apt-get update

COPY src /var/www/html/src
COPY exfil.php /var/www/html/
COPY index.html /var/www/html/

WORKDIR /var/www/html/src
RUN composer update
RUN chmod -R 777 bootstrap/cache/ storage/
RUN chmod +x /var/www/html/src/start.sh
RUN usermod -d /var/lib/mysql/ mysql

ENV DATE_TIMEZONE UTC

VOLUME /var/log/httpd

EXPOSE 80

CMD ["/var/www/html/src/start.sh"]
