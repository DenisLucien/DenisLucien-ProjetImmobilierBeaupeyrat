import { useEffect, useState } from "react";
import pic from "/House.jpg";

function Home() {
  const [logements, setLogements] = useState([]);
  function postPhoto() {
    fetch(pic)
      .then((res) => res.blob())
      .then((blob) => {
        const file = new File([blob], "House.jpg", { type: blob.type });
        const formData = new FormData();
        formData.append("file", file);
        console.log(file);
        console.log(formData);

        return fetch("http://localhost:8000/api/photos", {
          method: "POST",
          body: formData,
        });
      })
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        console.log("Fichier uploadé :", data);
      })
      .catch((error) => {
        console.error("Erreur :", error);
      });
  }

  useEffect(() => {
    fetch("http://localhost:8000/api/photos")
      .then((res) => res.json())
      .then((data) => {
        setLogements(data.member);
      });
  }, []);
  useEffect(() => {
    fetch("http://localhost:8000/api/users")
      .then((res) => res.json())
      .then((data) => {
        console.log(data);
      });
  }, []);
  console.log("haha");
  console.log(logements);

  return (
    <>
      <h1>Vite + React</h1>

      {logements && logements.length > 0
        ? logements.map((logement) => (
            <img
              key={logement.id}
              src={`http://localhost:8000/uploads/photos/${logement.source}`}
              alt=""
              style={{ maxWidth: "200px" }}
            />
          ))
        : null}

      <div className="card">
        <button onClick={() => postPhoto()}>Poster une Photo !</button>
        <p>
          Edit <code>src/App.jsx</code> and save to test HMR
        </p>
      </div>
      <p className="read-the-docs">
        Click on the Vite and React logos to learn more
      </p>
    </>
  );
}

export default Home;
