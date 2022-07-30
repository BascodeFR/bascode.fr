import * as React from "react";
import ReactDOM from "react-dom/client";
import { BrowserRouter } from "react-router-dom"
import { Routes, Route } from "react-router-dom"
import { Forum } from "./views/Forum";
import { TopicView } from "./views/TopicView";
import {Home} from "./views/Home"

function App(){
    return <Routes>
        <Route path="/" element={<Home/>}/>
        <Route path='/forum' element={<Forum/>}/>
        <Route path='/forum/base-de-donnee-1' element={<TopicView/>}/>
    </Routes>
}

ReactDOM.createRoot(document.getElementById('root')).render(<React.StrictMode>
    <BrowserRouter>
        <App/>
    </BrowserRouter>
</React.StrictMode>
)

