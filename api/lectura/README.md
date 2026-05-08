# API Documentation

## ClssTest Endpoints

This API provides several endpoints for querying data related to ClssTest.

### Listar Lectura

**Endpoint:** `/api/lectura/listarLectura`

- **Description:** Get a list of readings based on provided criteria.

- **Parameters**:
  - `cod` (Optional) - The code for a specific reading.
  - `categoria` (Optional) - The category ID to filter readings.
  - `subcategoria` (Optional) - The subcategory ID to filter readings.

- **Example Request:** `/api/lectura/listarLectura?cod=1&categoria=2&subcategoria=3`

- **Response**:
  - Returns a JSON array containing the list of readings based on the provided criteria.

### Listar Subcategoria

**Endpoint:** `/api/lectura/listarSubCategoria`

- **Description:** Get a list of subcategories based on provided criteria.

- **Parameters**:
  - `cod` (Optional) - The code for a specific subcategory.
  - `categoria` (Required) - The category ID to filter subcategories.

- **Example Request:** `/api/lectura/listarSubCategoria?cod=1&categoria=2`

- **Response**:
  - Returns a JSON array containing the list of subcategories based on the provided criteria.

### Listar Categoria

**Endpoint:** `/api/lectura/listarCategoria`

- **Description:** Get a list of categories based on provided criteria.

- **Parameters**:
  - `cod` (Optional) - The code for a specific category.
  - `slug` (Optional) - The slug for a specific category.

- **Example Request:** `/api/lectura/listarCategoria?cod=1&slug=example`

- **Response**:
  - Returns a JSON array containing the list of categories based on the provided criteria.

### Listar Pregunta

**Endpoint:** `/api/lectura/listarPregunta`

- **Description:** Get a list of questions based on provided criteria.

- **Parameters**:
  - `cod` (Optional) - The code for a specific question.
  - `lectura` (Required) - The reading ID to filter questions.

- **Example Request:** `/api/lectura/listarPregunta?cod=1&lectura=2`

- **Response**:
  - Returns a JSON array containing the list of questions based on the provided criteria.

### Listar Alternativas

**Endpoint:** `/api/lectura/listarAlternativas`

- **Description:** Get a list of alternatives based on provided criteria.

- **Parameters**:
  - `cod` (Optional) - The code for a specific alternative.
  - `pregunta` (Required) - The question ID to filter alternatives.

- **Example Request:** `/api/lectura/listarAlternativas?cod=1&pregunta=2`

- **Response**:
  - Returns a JSON array containing the list of alternatives based on the provided criteria.

### Listar Preguntas Con Alternativas

**Endpoint:** `/api/listarPreguntasConAlternativas`

- **Description:** Get a list of questions with their respective alternatives based on provided criteria.

- **Parameters**:
  - `cod` (Optional) - The code for a specific question.
  - `lectura` (Required) - The reading ID to filter questions.

- **Example Request:** `/api/listarPreguntasConAlternativas?cod=1&lectura=2`

- **Response**:
  - Returns a JSON array containing the list of questions with their respective alternatives based on the provided criteria. Each question in the array includes an "alternativas" field containing the list of alternatives.
  - This endpoint fetches questions using `listarPregunta` and retrieves alternatives for each question using `listarAlternativas`. It provides a consolidated response with questions and their alternatives.
