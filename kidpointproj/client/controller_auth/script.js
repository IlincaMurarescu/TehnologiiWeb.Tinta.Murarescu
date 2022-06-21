const signup = document.querySelector(".js-signup");
const login = document.querySelector(".js-login");

signup.addEventListener("click", () => {
  location.href = "./sign-up-page.html";
});

var responseStatus;
login.addEventListener("click", () => {
  const formData = new FormData(document.querySelector(".login-form"));

  fetch("http://localhost/kidpointproj/api_auth/controller/login.php", {
    method: "POST",
    body: formData,
    credentials: "include",
  })
    .then((res) => {
      responseStatus = res.status;
      return res.text();
    })
    .then((data) => {
      if (responseStatus != 200) {
        alert(data);
        console.log("cod 400");
      }
      if (responseStatus == 200) {
        location.href =
          "http://localhost/kidpointproj/client/views/MyChildren.html";
      }
    })
    .catch((err) => {
      console.log("e eroare");
      alert(err);
    });
});
