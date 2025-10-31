import { useState } from 'react'
import './App.css'

const data = [
  { value: 7, color: '#000000ff', id: 1 },
  { value: 8, color: '#0000FF', id: 2 }, 
  { value: 9, color: '#ff0000ff', id: 3 }, 
  { value: 4, color: '#FFA500', id: 4 }, 
  { value: 5, color: '#000000ff', id: 5 },
  { value: 6, color: '#0000FF', id: 6 }, 
  { value: 1, color: '#ff0000ff', id: 7 },
  { value: 2, color: '#FFA500', id: 8 }, 
  { value: 3, color: '#000000ff', id: 9 },
]

const MyColors = ({block}) => {
  const [isHovered, setHovered] = useState(false);

  const click = () => {
    alert(`The value of this block is ${block.value}`);
  };

  const style = {
    fontSize: '50px',
    fontFamily: 'Times New Roman Thin, serif', 
    backgroundColor: isHovered ? '#FFFF' : block.color,
    color: isHovered ? '#000000' : '#FFFFFF',
    width: '100px',
    height: '100px',
    display: 'flex',
    justifyContent: 'center',
    alignItems: 'center',
    fontWeight: 'bold',
    borderRadius: '4px',
    transition: 'background-color 0.1s',
  };

  return (
    <div style = {style}
        onClick = {click}
        onMouseEnter={() => setHovered(true)}
        onMouseLeave={() => setHovered(false)}
        role="button"
        tabIndex={0}
    >
      {block.value}
    </div>
  )
};

const ColorGrid = ({blocks}) => {
  return (
    <div className="colorGrid">
    {blocks.map (block => (<MyColors key = {block.id} block = {block}/>))}
    </div>
  );
};

const App = () => {
  return (
    <div className="center-container">
    <div style={{ padding: '500px', textAlign: 'center' }}>      
      <h1 style={{ fontFamily: 'Times New Roman, serif' }}>React Assignment Problem 2</h1>
      <p style={{ fontFamily: 'Times New Roman, serif' }}>Below is the grid</p>
      <ColorGrid blocks={data}/>
    </div>
    </div>
  );
}

export default App;