FROM nginx

#COPY nginx.conf /etc/nginx/conf.d/default.conf

COPY run_nginx.sh /usr/local/bin/run_nginx.sh
RUN chmod a+x /usr/local/bin/run_nginx.sh

ENTRYPOINT ["/bin/bash"]
CMD ["/usr/local/bin/run_nginx.sh"]
