fetch("http://localhost/kidpointproj/apimaps/controller/read.php")
  .then((response) => {
    if (!response.ok) {
      throw Error("Error");
    }
    // console.log(response);
    // console.log(response.text());
    return response.json();
  })
  .then((data) => {
    // console.log(data);
    // console.log(data[0].first_name);
    // console.log(data[1].first_name);
    // const html = data.map((child) => {
    //   return `<p>Name: ${child.first_name}`;
    // });
    let html = "";
    data.map((location) => {
      html += ` <div class="mylocations-list-element list-small-element" data-location="${location.location_id}" style="cursor: pointer;" onclick="changeMe(this)">
      <img
        class="icon location-icon"
        alt="House"
        src="SVG/home-heart-icon.svg"
      />
      <p class="location-name main-info-list-element">${location.title}</p>
      <p class="location-details info-list-element">
      ${location.longitude} ${location.latitude}
      </p>
    </div>`;
    });

    // console.log(html);
    document.querySelector(".mylocations-list").innerHTML = html;

    //   document.querySelector(
    //     ".mychildren-list"
    //   ).innerHTML = `<div class="mychildren-list-element">
    //   <img class="child-icon" alt="Child" src="SVG/child-icon.svg" />
    //   <p class="child-name">${data.data.first_name} ${data.data.last_name} </p>
    //   <p class="child-details">Last seen at ${data.data.longitude}</p>
    // </div>`;
  })
  .catch((error) => {
    console.log(error);
  });
