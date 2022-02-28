"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_Register_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Register.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Register.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "register",
  data: function data() {
    return {
      adminPass: "",
      adminChecked: false,
      name: "",
      kimchiEmail: "@kimchi.ru",
      email: "",
      password: "",
      password_confirmation: ""
    };
  },
  methods: {
    checkPass: function checkPass() {
      if (this.adminPass === "k1mch1") {
        this.adminChecked = true;
      } else {
        this.adminChecked = false;
        this.adminPass = "";
      }
    },
    register: function register() {
      var _this = this;

      this.checkPass(); // Отправляем запрос за X-XSRF-TOKEN

      if (this.adminChecked) {
        axios.get("/sanctum/csrf-cookie").then(function (response) {
          // Получив, отправляем запрос на /register с объектом (данные пользователя)
          axios.post("/register", {
            name: _this.name,
            email: _this.email + _this.kimchiEmail,
            password: _this.password,
            password_confirmation: _this.password_confirmation
          }).then(function (res) {
            // В локалсторедж сохраняем токен
            localStorage.setItem("token", res.config.headers["X-XSRF-TOKEN"]);

            _this.$router.push({
              name: "Home"
            });
          })["catch"](function (error) {
            // Объект ошибки для дальнейшей работы
            console.log(error);
          });
        });
        this.adminPass = "";
        this.adminChecked = false;
      } else {
        alert("Используйте Мастер-пароль Администратора");
      }
    }
  }
});

/***/ }),

/***/ "./resources/js/components/Register.vue":
/*!**********************************************!*\
  !*** ./resources/js/components/Register.vue ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Register_vue_vue_type_template_id_97358ae4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Register.vue?vue&type=template&id=97358ae4& */ "./resources/js/components/Register.vue?vue&type=template&id=97358ae4&");
/* harmony import */ var _Register_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Register.vue?vue&type=script&lang=js& */ "./resources/js/components/Register.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Register_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Register_vue_vue_type_template_id_97358ae4___WEBPACK_IMPORTED_MODULE_0__.render,
  _Register_vue_vue_type_template_id_97358ae4___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Register.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Register.vue?vue&type=script&lang=js&":
/*!***********************************************************************!*\
  !*** ./resources/js/components/Register.vue?vue&type=script&lang=js& ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Register_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Register.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Register.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Register_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Register.vue?vue&type=template&id=97358ae4&":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/Register.vue?vue&type=template&id=97358ae4& ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Register_vue_vue_type_template_id_97358ae4___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Register_vue_vue_type_template_id_97358ae4___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Register_vue_vue_type_template_id_97358ae4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Register.vue?vue&type=template&id=97358ae4& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Register.vue?vue&type=template&id=97358ae4&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Register.vue?vue&type=template&id=97358ae4&":
/*!********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Register.vue?vue&type=template&id=97358ae4& ***!
  \********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c(
      "form",
      {
        staticClass: "g-3 needs-validation",
        attrs: { novalidate: "" },
        on: {
          submit: function ($event) {
            $event.preventDefault()
            return _vm.register.apply(null, arguments)
          },
        },
      },
      [
        _c("div", { staticClass: "col-md-4 mx-auto pt-3" }, [
          _c(
            "label",
            { staticClass: "form-label", attrs: { for: "register_name" } },
            [_vm._v("Имя")]
          ),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.name,
                expression: "name",
              },
            ],
            staticClass: "form-control",
            attrs: {
              type: "text",
              id: "register_name",
              required: "",
              placeholder: "Укажите имя...",
            },
            domProps: { value: _vm.name },
            on: {
              input: function ($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.name = $event.target.value
              },
            },
          }),
          _vm._v(" "),
          _c("div", { staticClass: "valid-feedback" }, [_vm._v("Looks good!")]),
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-md-4 mx-auto pt-3" }, [
          _c(
            "label",
            { staticClass: "form-label", attrs: { for: "register_email" } },
            [_vm._v("Email")]
          ),
          _vm._v(" "),
          _c("div", { staticClass: "d-flex flex-row" }, [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.email,
                  expression: "email",
                },
              ],
              staticClass: "form-control",
              attrs: {
                type: "email",
                id: "register_email",
                required: "",
                placeholder: "Почта...",
              },
              domProps: { value: _vm.email },
              on: {
                input: function ($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.email = $event.target.value
                },
              },
            }),
            _vm._v(" "),
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.kimchiEmail,
                  expression: "kimchiEmail",
                },
              ],
              staticClass: "form-control",
              attrs: { type: "email", required: "", disabled: "" },
              domProps: { value: _vm.kimchiEmail },
              on: {
                input: function ($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.kimchiEmail = $event.target.value
                },
              },
            }),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "valid-feedback" }, [_vm._v("Looks good!")]),
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-md-4 mx-auto pt-3" }, [
          _c(
            "label",
            { staticClass: "form-label", attrs: { for: "register_password" } },
            [_vm._v("Пароль")]
          ),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.password,
                expression: "password",
              },
            ],
            staticClass: "form-control",
            attrs: {
              type: "password",
              id: "register_password",
              required: "",
              placeholder: "Придумайте пароль...",
            },
            domProps: { value: _vm.password },
            on: {
              input: function ($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.password = $event.target.value
              },
            },
          }),
          _vm._v(" "),
          _c("div", { staticClass: "valid-feedback" }, [_vm._v("Looks good!")]),
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-md-4 mx-auto pt-3" }, [
          _c(
            "label",
            {
              staticClass: "form-label",
              attrs: { for: "password_confirmation" },
            },
            [_vm._v("Повторите пароль")]
          ),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.password_confirmation,
                expression: "password_confirmation",
              },
            ],
            staticClass: "form-control",
            attrs: {
              type: "password",
              id: "password_confirmation",
              required: "",
              placeholder: "Повторите пароль...",
            },
            domProps: { value: _vm.password_confirmation },
            on: {
              input: function ($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.password_confirmation = $event.target.value
              },
            },
          }),
          _vm._v(" "),
          _c("div", { staticClass: "valid-feedback" }, [_vm._v("Looks good!")]),
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-md-4 mx-auto pt-3" }, [
          _c(
            "label",
            { staticClass: "form-label", attrs: { for: "AdminPassRegister" } },
            [_vm._v("Мастер-Пароль для завершения регистрации")]
          ),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.adminPass,
                expression: "adminPass",
              },
            ],
            staticClass: "form-control",
            attrs: {
              type: "password",
              id: "AdminPassRegister",
              "aria-describedby": "passwordHelpBlock",
              required: "",
            },
            domProps: { value: _vm.adminPass },
            on: {
              input: function ($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.adminPass = $event.target.value
              },
            },
          }),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "form-text", attrs: { id: "passwordHelpBlock" } },
            [
              _vm._v(
                "\n                Используйте Мастер-пароль Администратора для завершения\n                регистрации\n            "
              ),
            ]
          ),
        ]),
        _vm._v(" "),
        _vm._m(0),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass:
              "d-flex justify-content-center pt-3 align-items-center",
          },
          [
            _c("span", { staticClass: "me-2" }, [_vm._v("Есть аккаунта?")]),
            _vm._v(" "),
            _c("router-link", { attrs: { to: "/login" } }, [_vm._v(" Войти ")]),
          ],
          1
        ),
      ]
    ),
  ])
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "d-flex justify-content-center pt-3" }, [
      _c(
        "button",
        { staticClass: "btn btn-primary", attrs: { type: "submit" } },
        [_vm._v("\n                Зарегистрироваться\n            ")]
      ),
    ])
  },
]
render._withStripped = true



/***/ })

}]);