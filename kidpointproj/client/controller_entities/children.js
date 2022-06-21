fetch("http://localhost/kidpointproj/api_entities/controller/read.php")
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
    data.map((child) => {
      html += `<div class="mychildren-list-element" data-child="${child.child_id}" style="cursor: pointer;"  onclick="findMe(this)">
        <img class="child-icon" alt="Child" src="SVG/child-icon.svg" />
        <p class="child-name">${child.first_name} ${child.last_name} </p>
        <p class="child-details">Click on me to see my last location!</p>
      </div>`;
    });

    // console.log(html);
    document.querySelector(".mychildren-list").innerHTML = html;

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
