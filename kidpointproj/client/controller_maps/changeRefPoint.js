var $refpoint_id;
function changeMe(point) {
  $refpoint_id = point.getAttribute("data-location");
}

const btn = document.querySelector(".change-loc-js");
var responseStatus;
btn.addEventListener("click", () => {
  let data = {
    refpoint_id: $refpoint_id,
  };
  console.log(
    "........................................................................" +
      data
  );
  fetch(
    "http://localhost/kidpointproj/api_entities/controller/changepoint.php",
    {
      method: "PUT",
      body: JSON.stringify(data),
    }
  )
    .then((res) => {
      responseStatus = res.status;
      return res.text();
    })
    .then((data) => {
      if (responseStatus != 200) alert(data);
      if (responseStatus == 200) {
        alert(data);
        location.href =
          "http://localhost/kidpointproj/client/views/MyChildren.html";
      }
    })
    .catch((err) => {
      alert(err);
    });
});
