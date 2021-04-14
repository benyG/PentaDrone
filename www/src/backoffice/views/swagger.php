openapi: 3.0.1
info:
  title: <?= $title ?>  # Title of API
  version: <?= $version ?>  # Version of API
servers:
  - url: <?= $basePath ?: "/" ?>  # The "url: " prefix is required
paths:
  /api/login:
    post:
      tags:
        - Login
      requestBody:
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                username:
                  type: string
                password:
                  type: string
              required:
                - username
                - password
      responses:
        '200':
          description: Success
  '/api/list/{table}':
    get:
      tags:
        - List
      summary: List records from a table
      parameters:
        - name: table
          in: path
          required: true
          schema:
            type: string
      responses:
        '200':
          description: Success
  '/api/view/{table}/{key}':
    get:
      tags:
        - View
      summary: View a record from a table
      parameters:
        - name: table
          in: path
          required: true
          schema:
            type: string
        - name: key
          in: path
          required: true
          schema:
            type: string
      responses:
        '200':
          description: Success
  '/api/add/{table}':
    post:
      tags:
        - Add
      summary: Add a record to a table
      parameters:
        - name: table
          in: path
          required: true
          schema:
            type: string
      requestBody:
        required: true
        description: '*Note: Enter values as JSON, e.g. {"name1": "value1", "name2": "value2", ... }, make sure you double quote the field names.'
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
      responses:
        '200':
          description: Success
  '/api/delete/{table}/{key}':
    get:
      tags:
        - Delete
      summary: Delete a record from a table
      parameters:
        - name: table
          in: path
          required: true
          schema:
            type: string
        - name: key
          in: path
          required: true
          schema:
            type: string
      responses:
        '200':
          description: Success
  '/api/delete/{table}':
    post:
      tags:
        - Delete
      summary: Delete multiple records from a table
      parameters:
        - name: table
          in: path
          required: true
          schema:
            type: string
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                key_m[]:
                  type: array
                  items:
                    type: string
            encoding:
              # Don't percent-encode reserved characters in the values of "bar" and "baz" fields
              key_m[]:
                allowReserved: true
      responses:
        '200':
          description: Success
  '/api/edit/{table}/{key}':
    post:
      tags:
        - Edit
      summary: Edit a record in a table
      parameters:
        - name: table
          in: path
          required: true
          schema:
            type: string
        - name: key
          in: path
          required: true
          schema:
            type: string
      requestBody:
        required: true
        description: '*Note: Enter values as JSON, e.g. {"name1": "value1", "name2": "value2", ... }, make sure you double quote the field names.'
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
      responses:
        '200':
          description: Success
  '/api/file/{table}/{field}/{key}':
    get:
      tags:
        - File
      summary: Get file(s) info from a table by primary key
      parameters:
        - name: table
          in: path
          required: true
          schema:
            type: string
        - name: field
          in: path
          required: true
          schema:
            type: string
        - name: key
          in: path
          required: true
          schema:
            type: string
      responses:
        '200':
          description: Success
  '/api/file/{table}/{fn}':
    get:
      tags:
        - File
      summary: Get a file from a table by encrypted file path
      parameters:
        - name: table
          in: path
          required: true
          schema:
            type: string
        - name: fn
          in: path
          required: true
          schema:
            type: string
      responses:
        '200':
          description: Success
  '/api/permissions/{userlevel}':
    get:
      tags:
        - Permissions
      summary: Get permissions of a user level
      parameters:
        - name: userlevel
          in: path
          required: true
          schema:
            type: string
      responses:
        '200':
          description: Success
    post:
      tags:
        - Permissions
      summary: Update permissions of a user level
      parameters:
        - name: userlevel
          in: path
          required: true
          schema:
            type: string
      requestBody:
        required: true
        description: '*Note: Enter values as JSON, e.g. {"name1": value1, "name2": value2, ... }, make sure you double quote the table names.'
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
      responses:
        '200':
          description: Success
  /api/register:
    post:
      tags:
        - Register
      summary: Register a new user
      requestBody:
        required: true
        description: '*Note: Enter values as JSON, e.g. {"name1": "value1", "name2": "value2", ... }, make sure you double quote the field names.'
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
      responses:
        '200':
          description: Success
  /api/upload:
    post:
      tags:
        - Upload
      summary: Upload file(s)
      requestBody:
        content:
          multipart/form-data:
            schema:
              type: object
              properties:
                files[]:
                  type: array
                  items:
                    type: string
                    format: binary
            encoding:
              files[]:
                allowReserved: true
      responses:
        '200':
          description: Success
components:
  securitySchemes:
    Bearer:
      type: apiKey
      description: '*Note: Login to get your the JWT token first, then enter "Bearer &lt;JWT Token&gt;" below, e.g.<br><em>Bearer 123456abcdef</em>'
      name: X-Authorization  # PHP
      in: header
security:
  - Bearer: []