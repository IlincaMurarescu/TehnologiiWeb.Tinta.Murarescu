const deleteacc = document.querySelector(".js-delete");
var responseStatus;
deleteacc.addEventListener("click", () => {
  fetch("http://localhost/kidpointproj/api_auth/controller/delete.php", {
    method: "DELETE",
  })
    .then((res) => {
      responseStatus = res.status;
      return res.text();
    })
    .then((data) => {
      if (responseStatus != 200) alert(data);
      if (responseStatus == 200)
        location.href = "http://localhost/kidpointproj/client/views/index.html";
    })
    .catch((err) => {
      alert(err);
    });
});
