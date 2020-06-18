
## A Simple Movie Api

<table>
  <tr>
    <th>Method</th>
    <th>URL</th>
    <th>Error Status</th>
     <th>Success Status</th>
  </tr>
  <tr>
    <td>GET</td>
    <td>api/v1/movies</td>
    <td>404: No movie is available</td>
     <td>200 : Returns all movie</td>
  </tr>
  <tr>
    <td>POST</td>
    <td>/api/v1/addMovie</td>
    <td>422..Displays errors</td>
    <td>200..Your Movie Has been Uploaded</td>
  </tr>
  <tr>
    <td>GET</td>
    <td>api/v1/view/{id}</td>
    <td>404..Not found</td>
     <td>200..Displays details of a movie</td>
  </tr>
  <tr>
    <td>PUT</td>
    <td>api/v1/updateMovie/{id}</td>
    <td>422 : Displays errors,  404: Not Found</td>
     <td>200 : Movie Details Has been Updated</td>
  </tr>
    <tr>
    <td>DELETE</td>
    <td>/api/v1/deleteMovie/{id}</td>
    <td>422 : Displays errors,  404: Not Found</td>
     <td>200 : Movie Details Has been Updated</td>
  </tr>
  <tr>
    <td>GET</td>
    <td>/api/v1/search</td>
    <td>404: Not Found..Title is not available</td>
    <td>200: Display Details of Movie</td>
  </tr>
</table>




Written by Kalu Prosper

