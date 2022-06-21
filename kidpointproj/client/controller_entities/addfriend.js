const signup = document.querySelector(".js-add");
var responseStatus;
signup.addEventListener("click", () => {
  const formData = new FormData(document.querySelector(".add-friend-form"));
  fetch(
    "http://localhost/kidpointproj/api_entities/controller/create-friend.php",
    {
      method: "POST",
      body: formData,
    }
  )
    .then((res) => {
      responseStatus = res.status;
      return res.text();
    })
    .then((data) => {
      if (responseStatus != 200) alert(data);
      if (responseStatus == 200)
        location.href =
          "http://localhost/kidpointproj/client/views/MyFriends.html";
      // console.log(data);
    })
    .catch((err) => {
      alert(err);
    });
});
