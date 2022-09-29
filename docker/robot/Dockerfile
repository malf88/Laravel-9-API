FROM python:3-slim-buster

WORKDIR /testes
ENV VIRTUAL_ENV=${UHOME}/venv

ENV PATH="$VIRTUAL_ENV/bin:$PATH"

RUN apt-get update -y  && \
    apt-get install -y \
    libpq-dev \
    gcc && \
    pip3 install --no-cache-dir --upgrade pip && \
    pip3 install -U --no-cache-dir  \
              robotframework \
              robotframework-requests \
              robotframework-databaselibrary \
              psycopg2


CMD python3 -m robot --outputdir /report --loglevel trace --removekeywords name:Connect_To_Database .
