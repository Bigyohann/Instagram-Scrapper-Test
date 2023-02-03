import './global.d.ts';
import './bootstrap';
import React from "react";
import ReactDOM from "react-dom/client"
import {App} from "../Components/App/App";

let rootElement = document.querySelector('#root');
if (rootElement) {
    const root = ReactDOM.createRoot(rootElement);
    root.render(
        <div>
            <React.Fragment>
                <App/>
            </React.Fragment>
        </div>);

} else {
    console.log('root div is needed to start react');
}
