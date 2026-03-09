import './App.css';
import Barsukas from './components/01/barsukas';
import Bebras from './components/01/bebras';

function App() {

  return (
    <div className="App">
      <h1>Mano <br /> React</h1>
      <Bebras></Bebras>
      <Barsukas koks="geras" ></Barsukas>
      <Barsukas koks="blogas"></Barsukas>
    </div>
  );
}

export default App;
