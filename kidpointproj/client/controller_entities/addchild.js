const signup = document.querySelector(".js-add");
var responseStatus;
signup.addEventListener("click", () => {
  const formData = new FormData(document.querySelector(".child-form"));
  fetch("http://localhost/kidpointproj/api_entities/controller/create.php", {
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
          "http://localhost/kidpointproj/client/views/MyChildren.html";
    })
    .catch((err) => {
      alert(err);
    });
});
