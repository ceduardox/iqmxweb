# API Documentation

## ClssTestiQ Endpoints

This API provides several endpoints for querying data related to ClssTestiQ.

### Listar Tipo

**Endpoint:** `/api/iq/listarTipo`

- **Description:** Get a list of types based on provided criteria.

- **Parameters**:
  - `cod` (Optional) - The code for a specific type.
  - `slug` (Optional) - The slug for a specific type.

- **Example Request:** `/api/iq/listarTipo?cod=1&slug=example`

- **Response**:
  - Returns a JSON array containing the list of types based on the provided criteria.

### Listar Serie Tipo

**Endpoint:** `/api/iq/listarSerieTipo`

- **Description:** Get a list of series types based on provided criteria.

- **Parameters**:
  - `cod` (Optional) - The code for a specific series type.

- **Example Request:** `/api/iq/listarSerieTipo?cod=1`

- **Response**:
  - Returns a JSON array containing the list of series types based on the provided criteria.

### Listar Serie

**Endpoint:** `/api/iq/listarSerie`

- **Description:** Get a list of series based on provided criteria.

- **Parameters**:
  - `cod` (Optional) - The code for a specific series.
  - `tipo` (Optional) - The type of series.

- **Example Request:** `/api/iq/listarSerie?cod=1&tipo=2`

- **Response**:
  - Returns a JSON array containing the list of series based on the provided criteria.

### Listar Pregunta

**Endpoint:** `/api/iq/listarPregunta`

- **Description:** Get a list of questions based on provided criteria.

- **Parameters**:
  - `cod` (Optional) - The code for a specific question.
  - `serie` (Required) - The series ID to filter questions.

- **Example Request:** `/api/iq/listarPregunta?serie=3`

- **Response**:
  - Returns a JSON array containing the list of questions based on the provided criteria.

### Listar Alternativa

**Endpoint:** `/api/iq/listarAlternativa`

- **Description:** Get a list of alternatives based on provided criteria.

- **Parameters**:
  - `cod` (Optional) - The code for a specific alternative.
  - `pregunta` (Required) - The question ID to filter alternatives.

- **Example Request:** `/api/iq/listarAlternativa?pregunta=5`

- **Response**:
  - Returns a JSON array containing the list of alternatives based on the provided criteria.

### Listar Serie con Preguntas y sus Alternativas

**Endpoint:** `/api/listarSerieConPreguntasAlternativas`

- **Description:** This endpoint retrieves a list of series along with their questions and alternatives.

- **Parameters**:
  - `cod` (optional): The code of the series (default: empty).
  - `tipo` (optional): The type of the series (default: empty).

- **Example Request** `/api/iq/listarSerieConPreguntasAlternativas?tipo=1`

- **Response**:
  - Returns a JSON array containing a list of series along with their questions and alternatives.
