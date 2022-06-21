const signup = document.querySelector(".js-save");
var responseStatus;
signup.addEventListener("click", () => {
  const formData = new FormData(document.querySelector(".my-account-form"));
  fetch("http://localhost/kidpointproj/api_auth/controller/update-user.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => {
      responseStatus = res.status;
      return res.text();
    })
    .then((data) => {
      if (responseStatus != 200) alert(data);
      if (responseStatus == 200)
        location.href =
          "http://localhost/kidpointproj/client/views/my-account.html";
    })
    .catch((err) => {
      alert(err);
    });
});
