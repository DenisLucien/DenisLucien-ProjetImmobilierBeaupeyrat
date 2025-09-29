import { useEffect, useState } from 'react'
import reactLogo from './assets/react.svg'
import viteLogo from '/vite.svg'
import pic from '/House.jpg'
import './App.css'

function App() {
  function postPhoto() {
  fetch(pic)               // récupère le fichier depuis l’URL générée par Vite
      .then(res => res.blob()) // transforme en Blob
    .then(blob => {
      const file = new File([blob], "House.jpg", { type: blob.type });
      const formData = new FormData();
      formData.append("file", file);
        
      return fetch("http://localhost:3000/api/upload", {
        method: "POST",
        body: formData,
      });
    })
    .then((response) => response.json())
    .then((data) => {
      console.log("Fichier uploadé :", data.filename);
    })
    .catch((error) => {
      console.error("Erreur :", error);
    });
  }
  
  return (
    <>
      <div>
        <a href="https://vite.dev" target="_blank">
          <img src={viteLogo} className="logo" alt="Vite logo" />
        </a>
        <a href="https://react.dev" target="_blank">
          <img src={reactLogo} className="logo react" alt="React logo" />
        </a>
      </div>
      <h1>Vite + React</h1>
      <div className="card">
        <button onClick={() => postPhoto(pic)}>
         Poster une Photo !
        </button>
        <p>
          Edit <code>src/App.jsx</code> and save to test HMR
        </p>
      </div>
      <p className="read-the-docs">
        Click on the Vite and React logos to learn more
      </p>
    </>
  )
}

export default App
