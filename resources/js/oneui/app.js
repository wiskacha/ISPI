/*
 *  Document   : app.js
 *  Author     : pixelcave
 *  Description: Main entry point
 *
 */

// Import required modules
import Template from "./modules/template.js";

// App extends Template
export default class App extends Template {
  /*
   * Auto called when creating a new instance
   *
   */
  constructor() {
    super();
  }

  /*
   *  Here you can override or extend any function you want from Template class
   *  if you would like to change/extend/remove the default functionality.
   *
   *  This way it will be easier for you to update the module files if a new update
   *  is released since all your changes will be in here overriding the original ones.
   *
   *  Let's have a look at the _uiInit() function, the one that runs the first time
   *  we create an instance of Template class or App class which extends it. This function
   *  inits all vital functionality but you can change it to fit your own needs.
   *
   */
  _uiApiLayout(mode = "init") {
    let self = this;

    // API with object literals
    let layoutAPI = {
      init: () => {
        let buttons = document.querySelectorAll('[data-toggle="layout"]');

        // Call layout API on button click
        if (buttons) {
          buttons.forEach((btn) => {
            btn.addEventListener("click", (e) => {
              self._uiApiLayout(btn.dataset.action);
            });
          });
        }

        // Force header to be dark
        self._uiApiLayout("header_style_dark");
      },
      // Other layout methods
      sidebar_pos_toggle: () => {
        self._lPage.classList.toggle("sidebar-r");
      },
      sidebar_pos_left: () => {
        self._lPage.classList.remove("sidebar-r");
      },
      sidebar_pos_right: () => {
        self._lPage.classList.add("sidebar-r");
      },
      sidebar_toggle: () => {
        if (window.innerWidth > 991) {
          self._lPage.classList.toggle("sidebar-o");
        } else {
          self._lPage.classList.toggle("sidebar-o-xs");
        }
      },
      sidebar_open: () => {
        if (window.innerWidth > 991) {
          self._lPage.classList.add("sidebar-o");
        } else {
          self._lPage.classList.add("sidebar-o-xs");
        }
      },
      sidebar_close: () => {
        if (window.innerWidth > 991) {
          self._lPage.classList.remove("sidebar-o");
        } else {
          self._lPage.classList.remove("sidebar-o-xs");
        }
      },
      sidebar_mini_toggle: () => {
        if (window.innerWidth > 991) {
          self._lPage.classList.toggle("sidebar-mini");
        }
      },
      sidebar_mini_on: () => {
        if (window.innerWidth > 991) {
          self._lPage.classList.add("sidebar-mini");
        }
      },
      sidebar_mini_off: () => {
        if (window.innerWidth > 991) {
          self._lPage.classList.remove("sidebar-mini");
        }
      },
      sidebar_style_toggle: () => {
        if (self._lPage.classList.contains("sidebar-dark")) {
          self._uiApiLayout("sidebar_style_light");
        } else {
          self._uiApiLayout("sidebar_style_dark");
        }
      },
      sidebar_style_dark: () => {
        self._lPage.classList.add("sidebar-dark");
        localStorage.setItem("oneuiDefaultsSidebarDark", true);
      },
      sidebar_style_light: () => {
        self._lPage.classList.remove("sidebar-dark");
        localStorage.removeItem("oneuiDefaultsSidebarDark");
      },
      header_style_dark: () => {
        self._lPage.classList.add("page-header-dark");
        localStorage.setItem("oneuiDefaultsHeaderDark", true);
      },
      header_style_light: () => {
        self._lPage.classList.remove("page-header-dark");
        localStorage.removeItem("oneuiDefaultsHeaderDark");
      },
      side_overlay_toggle: () => {
        if (self._lPage.classList.contains("side-overlay-o")) {
          self._uiApiLayout("side_overlay_close");
        } else {
          self._uiApiLayout("side_overlay_open");
        }
      },
      side_overlay_open: () => {
        // When ESCAPE key is hit close the side overlay
        document.addEventListener("keydown", (e) => {
          if (e.key === "Esc" || e.key === "Escape") {
            self._uiApiLayout("side_overlay_close");
          }
        });
      },
    };

    // Execute API function
    if (layoutAPI[mode]) {
      layoutAPI[mode]();
    }
  }

  /*
   * EXAMPLE #1 - Removing default functionality by making it empty
   *
   */

  //  _uiInit() {}

  /*
   * EXAMPLE #2 - Extending default functionality with additional code
   *
   */

  //  _uiInit() {
  //      // Call original function
  //      super._uiInit();
  //
  //      // Your extra JS code afterwards
  //  }

  /*
   * EXAMPLE #3 - Replacing default functionality by writing your own code
   *
   */

  //  _uiInit() {
  //      // Your own JS code without ever calling the original function's code
  //  }
}

// Create a new instance of App
window.One = new App();
