/** @format */

import domReady from "@wordpress/dom-ready";
import { createRoot } from "@wordpress/element";
import "./index.scss";

const HelloReactPage = () => {
  return <h1>Hello Reacttttt</h1>;
};

domReady(() => {
  const root = createRoot(document.getElementById("root"));
  root.render(<HelloReactPage />);
});
