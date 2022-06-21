const logout = document.querySelector(".js-logout");
var responseStatus;
logout.addEventListener("click", () => {
  fetch("http://localhost/kidpointproj/api_auth/controller/logout.php")
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
