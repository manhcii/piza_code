{{-- Get menu id in component $component->json_params->menu_id --}}
@php
  $params['status'] = App\Consts::STATUS['active'];
  $params['is_featured'] = true;
  $params['is_type'] = App\Consts::TAXONOMY['post'];
  $rows_post = App\Models\CmsPost::getsqlCmsPost($params)
      ->limit(3)
      ->get();
@endphp
<div
                        class="offcanvas offcanvas-start"
                        tabindex="-1"
                        id="menu-mobile"
                        aria-labelledby="menu-mobileLabel"
                    >
                        <div class="offcanvas-body">
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="offcanvas"
                                aria-label="Close"
                            ></button>

                            <nav class="header-nav-mobile">
                                <ul class="header-nav-list">
                                    <li class="position-relative">
                                        <a
                                            href="products.html"
                                            class="header-nav-item"
                                            >Products</a
                                        >
                                        <ul
                                            class="header-nav-list-lv0 collapse"
                                            id="collapsesubmenu-1"
                                        >
                                            <li class="position-relative">
                                                <a
                                                    href="#"
                                                    class="header-nav-item"
                                                    >Pizza Dress</a
                                                >
                                                <ul
                                                    class="header-nav-list-lv1 collapse"
                                                    id="collapsesubmenu-lv1-1"
                                                >
                                                    <li>
                                                        <a
                                                            href="#"
                                                            class="header-nav-item"
                                                            >Pizza SeaFood</a
                                                        >
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="#"
                                                            class="header-nav-item"
                                                            >Spicy Pizza</a
                                                        >
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="#"
                                                            class="header-nav-item"
                                                            >Tomato Pizza</a
                                                        >
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="#"
                                                            class="header-nav-item"
                                                            >Chicken Pizza</a
                                                        >
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="#"
                                                            class="header-nav-item"
                                                            >Pizza Size Big</a
                                                        >
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="#"
                                                            class="header-nav-item"
                                                            >Pizza Small</a
                                                        >
                                                    </li>
                                                </ul>

                                                <div
                                                    class="close-sub-nav collapsed"
                                                    data-bs-toggle="collapse"
                                                    href="#collapsesubmenu-lv1-1"
                                                    role="button"
                                                    aria-expanded="false"
                                                    aria-controls="collapsesubmenulv1-1"
                                                >
                                                    <svg
                                                        version="1.1"
                                                        id="Capa_1"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                        x="0px"
                                                        y="0px"
                                                        viewBox="0 0 512 512"
                                                        style="
                                                            enable-background: new
                                                                0 0 512 512;
                                                        "
                                                        xml:space="preserve"
                                                    >
                                                        <g>
                                                            <g>
                                                                <path
                                                                    d="M492,236H276V20c0-11.046-8.954-20-20-20c-11.046,0-20,8.954-20,20v216H20c-11.046,0-20,8.954-20,20s8.954,20,20,20h216			v216c0,11.046,8.954,20,20,20s20-8.954,20-20V276h216c11.046,0,20-8.954,20-20C512,244.954,503.046,236,492,236z"
                                                                />
                                                            </g>
                                                        </g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                    </svg>

                                                    <svg
                                                        id="svg1591"
                                                        height="24"
                                                        viewBox="0 0 6.3499999 6.3500002"
                                                        width="24"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:svg="http://www.w3.org/2000/svg"
                                                    >
                                                        <g
                                                            id="layer1"
                                                            transform="translate(0 -290.65)"
                                                        >
                                                            <path
                                                                id="path2047"
                                                                d="m.79427278 293.56039a.2646485.2646485 0 0 0 0 .52917h4.76146822a.2646485.2646485 0 0 0 0-.52917z"
                                                                font-variant-ligatures="normal"
                                                                font-variant-position="normal"
                                                                font-variant-caps="normal"
                                                                font-variant-numeric="normal"
                                                                font-variant-alternates="normal"
                                                                font-feature-settings="normal"
                                                                text-indent="0"
                                                                text-align="start"
                                                                text-decoration-line="none"
                                                                text-decoration-style="solid"
                                                                text-decoration-color="rgb(0,0,0)"
                                                                text-transform="none"
                                                                text-orientation="mixed"
                                                                white-space="normal"
                                                                shape-padding="0"
                                                                isolation="auto"
                                                                mix-blend-mode="normal"
                                                                solid-color="rgb(0,0,0)"
                                                                solid-opacity="1"
                                                                vector-effect="none"
                                                            />
                                                        </g>
                                                    </svg>
                                                </div>
                                            </li>

                                            <li class="position-relative">
                                                <a
                                                    href="#"
                                                    class="header-nav-item"
                                                    >Drink</a
                                                >
                                                <ul
                                                    class="header-nav-list-lv1 collapse"
                                                    id="collapsesubmenu-lv1-2"
                                                >
                                                    <li>
                                                        <a
                                                            href="#"
                                                            class="header-nav-item"
                                                            >Cocacola</a
                                                        >
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="#"
                                                            class="header-nav-item"
                                                            >Pepsi</a
                                                        >
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="#"
                                                            class="header-nav-item"
                                                            >Beer</a
                                                        >
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="#"
                                                            class="header-nav-item"
                                                            >Soju</a
                                                        >
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="#"
                                                            class="header-nav-item"
                                                            >Watermelon</a
                                                        >
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="#"
                                                            class="header-nav-item"
                                                            >TH Truemilk</a
                                                        >
                                                    </li>
                                                </ul>

                                                <div
                                                    class="close-sub-nav collapsed"
                                                    data-bs-toggle="collapse"
                                                    href="#collapsesubmenu-lv1-2"
                                                    role="button"
                                                    aria-expanded="false"
                                                    aria-controls="collapsesubmenu-lv1-2"
                                                >
                                                    <svg
                                                        version="1.1"
                                                        id="Capa_1"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                        x="0px"
                                                        y="0px"
                                                        viewBox="0 0 512 512"
                                                        style="
                                                            enable-background: new
                                                                0 0 512 512;
                                                        "
                                                        xml:space="preserve"
                                                    >
                                                        <g>
                                                            <g>
                                                                <path
                                                                    d="M492,236H276V20c0-11.046-8.954-20-20-20c-11.046,0-20,8.954-20,20v216H20c-11.046,0-20,8.954-20,20s8.954,20,20,20h216			v216c0,11.046,8.954,20,20,20s20-8.954,20-20V276h216c11.046,0,20-8.954,20-20C512,244.954,503.046,236,492,236z"
                                                                />
                                                            </g>
                                                        </g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                    </svg>

                                                    <svg
                                                        id="svg1591"
                                                        height="24"
                                                        viewBox="0 0 6.3499999 6.3500002"
                                                        width="24"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:svg="http://www.w3.org/2000/svg"
                                                    >
                                                        <g
                                                            id="layer1"
                                                            transform="translate(0 -290.65)"
                                                        >
                                                            <path
                                                                id="path2047"
                                                                d="m.79427278 293.56039a.2646485.2646485 0 0 0 0 .52917h4.76146822a.2646485.2646485 0 0 0 0-.52917z"
                                                                font-variant-ligatures="normal"
                                                                font-variant-position="normal"
                                                                font-variant-caps="normal"
                                                                font-variant-numeric="normal"
                                                                font-variant-alternates="normal"
                                                                font-feature-settings="normal"
                                                                text-indent="0"
                                                                text-align="start"
                                                                text-decoration-line="none"
                                                                text-decoration-style="solid"
                                                                text-decoration-color="rgb(0,0,0)"
                                                                text-transform="none"
                                                                text-orientation="mixed"
                                                                white-space="normal"
                                                                shape-padding="0"
                                                                isolation="auto"
                                                                mix-blend-mode="normal"
                                                                solid-color="rgb(0,0,0)"
                                                                solid-opacity="1"
                                                                vector-effect="none"
                                                            />
                                                        </g>
                                                    </svg>
                                                </div>
                                            </li>
                                            <li class="position-relative">
                                                <a
                                                    href="#"
                                                    class="header-nav-item"
                                                    >By Brands</a
                                                >
                                                <ul
                                                    class="header-nav-list-lv1 collapse"
                                                    id="collapsesubmenu-lv1-3"
                                                >
                                                    <li>
                                                        <a
                                                            href="#"
                                                            class="header-nav-item"
                                                            >Domino</a
                                                        >
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="#"
                                                            class="header-nav-item"
                                                            >Pizza hut</a
                                                        >
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="#"
                                                            class="header-nav-item"
                                                            >Pizza 4P</a
                                                        >
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="#"
                                                            class="header-nav-item"
                                                            >KFC pizza</a
                                                        >
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="#"
                                                            class="header-nav-item"
                                                            >Lemon Pizza</a
                                                        >
                                                    </li>
                                                </ul>

                                                <div
                                                    class="close-sub-nav collapsed"
                                                    data-bs-toggle="collapse"
                                                    href="#collapsesubmenu-lv1-3"
                                                    role="button"
                                                    aria-expanded="false"
                                                    aria-controls="collapsesubmenu-lv1-3"
                                                >
                                                    <svg
                                                        version="1.1"
                                                        id="Capa_1"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                        x="0px"
                                                        y="0px"
                                                        viewBox="0 0 512 512"
                                                        style="
                                                            enable-background: new
                                                                0 0 512 512;
                                                        "
                                                        xml:space="preserve"
                                                    >
                                                        <g>
                                                            <g>
                                                                <path
                                                                    d="M492,236H276V20c0-11.046-8.954-20-20-20c-11.046,0-20,8.954-20,20v216H20c-11.046,0-20,8.954-20,20s8.954,20,20,20h216			v216c0,11.046,8.954,20,20,20s20-8.954,20-20V276h216c11.046,0,20-8.954,20-20C512,244.954,503.046,236,492,236z"
                                                                />
                                                            </g>
                                                        </g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                    </svg>

                                                    <svg
                                                        id="svg1591"
                                                        height="24"
                                                        viewBox="0 0 6.3499999 6.3500002"
                                                        width="24"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:svg="http://www.w3.org/2000/svg"
                                                    >
                                                        <g
                                                            id="layer1"
                                                            transform="translate(0 -290.65)"
                                                        >
                                                            <path
                                                                id="path2047"
                                                                d="m.79427278 293.56039a.2646485.2646485 0 0 0 0 .52917h4.76146822a.2646485.2646485 0 0 0 0-.52917z"
                                                                font-variant-ligatures="normal"
                                                                font-variant-position="normal"
                                                                font-variant-caps="normal"
                                                                font-variant-numeric="normal"
                                                                font-variant-alternates="normal"
                                                                font-feature-settings="normal"
                                                                text-indent="0"
                                                                text-align="start"
                                                                text-decoration-line="none"
                                                                text-decoration-style="solid"
                                                                text-decoration-color="rgb(0,0,0)"
                                                                text-transform="none"
                                                                text-orientation="mixed"
                                                                white-space="normal"
                                                                shape-padding="0"
                                                                isolation="auto"
                                                                mix-blend-mode="normal"
                                                                solid-color="rgb(0,0,0)"
                                                                solid-opacity="1"
                                                                vector-effect="none"
                                                            />
                                                        </g>
                                                    </svg>
                                                </div>
                                            </li>
                                            <li class="position-relative">
                                                <a
                                                    href="#"
                                                    class="header-nav-item"
                                                    >Accessories</a
                                                >
                                                <ul
                                                    class="header-nav-list-lv1 collapse"
                                                    id="collapsesubmenu-lv1-4"
                                                >
                                                    <li>
                                                        <a
                                                            href="#"
                                                            class="header-nav-item"
                                                            >Water</a
                                                        >
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="#"
                                                            class="header-nav-item"
                                                            >Paper</a
                                                        >
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="#"
                                                            class="header-nav-item"
                                                            >Eight</a
                                                        >
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="#"
                                                            class="header-nav-item"
                                                            >Chopstick</a
                                                        >
                                                    </li>
                                                </ul>

                                                <div
                                                    class="close-sub-nav collapsed"
                                                    data-bs-toggle="collapse"
                                                    href="#collapsesubmenu-lv1-4"
                                                    role="button"
                                                    aria-expanded="false"
                                                    aria-controls="collapsesubmenu-lv1-4"
                                                >
                                                    <svg
                                                        version="1.1"
                                                        id="Capa_1"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                        x="0px"
                                                        y="0px"
                                                        viewBox="0 0 512 512"
                                                        style="
                                                            enable-background: new
                                                                0 0 512 512;
                                                        "
                                                        xml:space="preserve"
                                                    >
                                                        <g>
                                                            <g>
                                                                <path
                                                                    d="M492,236H276V20c0-11.046-8.954-20-20-20c-11.046,0-20,8.954-20,20v216H20c-11.046,0-20,8.954-20,20s8.954,20,20,20h216			v216c0,11.046,8.954,20,20,20s20-8.954,20-20V276h216c11.046,0,20-8.954,20-20C512,244.954,503.046,236,492,236z"
                                                                />
                                                            </g>
                                                        </g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                    </svg>

                                                    <svg
                                                        id="svg1591"
                                                        height="24"
                                                        viewBox="0 0 6.3499999 6.3500002"
                                                        width="24"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:svg="http://www.w3.org/2000/svg"
                                                    >
                                                        <g
                                                            id="layer1"
                                                            transform="translate(0 -290.65)"
                                                        >
                                                            <path
                                                                id="path2047"
                                                                d="m.79427278 293.56039a.2646485.2646485 0 0 0 0 .52917h4.76146822a.2646485.2646485 0 0 0 0-.52917z"
                                                                font-variant-ligatures="normal"
                                                                font-variant-position="normal"
                                                                font-variant-caps="normal"
                                                                font-variant-numeric="normal"
                                                                font-variant-alternates="normal"
                                                                font-feature-settings="normal"
                                                                text-indent="0"
                                                                text-align="start"
                                                                text-decoration-line="none"
                                                                text-decoration-style="solid"
                                                                text-decoration-color="rgb(0,0,0)"
                                                                text-transform="none"
                                                                text-orientation="mixed"
                                                                white-space="normal"
                                                                shape-padding="0"
                                                                isolation="auto"
                                                                mix-blend-mode="normal"
                                                                solid-color="rgb(0,0,0)"
                                                                solid-opacity="1"
                                                                vector-effect="none"
                                                            />
                                                        </g>
                                                    </svg>
                                                </div>
                                            </li>
                                            <li class="position-relative">
                                                <a
                                                    href="#"
                                                    class="header-nav-item"
                                                    >Pasta</a
                                                >
                                                <ul
                                                    class="header-nav-list-lv1 collapse"
                                                    id="collapsesubmenu-lv1-5"
                                                >
                                                    <li>
                                                        <a
                                                            href="#"
                                                            class="header-nav-item"
                                                            >Pasta Beef</a
                                                        >
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="#"
                                                            class="header-nav-item"
                                                            >Pasta Chicken</a
                                                        >
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="#"
                                                            class="header-nav-item"
                                                            >Seafood tomato</a
                                                        >
                                                    </li>
                                                </ul>

                                                <div
                                                    class="close-sub-nav collapsed"
                                                    data-bs-toggle="collapse"
                                                    href="#collapsesubmenu-lv1-5"
                                                    role="button"
                                                    aria-expanded="false"
                                                    aria-controls="collapsesubmenu-lv1-5"
                                                >
                                                    <svg
                                                        version="1.1"
                                                        id="Capa_1"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                        x="0px"
                                                        y="0px"
                                                        viewBox="0 0 512 512"
                                                        style="
                                                            enable-background: new
                                                                0 0 512 512;
                                                        "
                                                        xml:space="preserve"
                                                    >
                                                        <g>
                                                            <g>
                                                                <path
                                                                    d="M492,236H276V20c0-11.046-8.954-20-20-20c-11.046,0-20,8.954-20,20v216H20c-11.046,0-20,8.954-20,20s8.954,20,20,20h216			v216c0,11.046,8.954,20,20,20s20-8.954,20-20V276h216c11.046,0,20-8.954,20-20C512,244.954,503.046,236,492,236z"
                                                                />
                                                            </g>
                                                        </g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                        <g></g>
                                                    </svg>

                                                    <svg
                                                        id="svg1591"
                                                        height="24"
                                                        viewBox="0 0 6.3499999 6.3500002"
                                                        width="24"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:svg="http://www.w3.org/2000/svg"
                                                    >
                                                        <g
                                                            id="layer1"
                                                            transform="translate(0 -290.65)"
                                                        >
                                                            <path
                                                                id="path2047"
                                                                d="m.79427278 293.56039a.2646485.2646485 0 0 0 0 .52917h4.76146822a.2646485.2646485 0 0 0 0-.52917z"
                                                                font-variant-ligatures="normal"
                                                                font-variant-position="normal"
                                                                font-variant-caps="normal"
                                                                font-variant-numeric="normal"
                                                                font-variant-alternates="normal"
                                                                font-feature-settings="normal"
                                                                text-indent="0"
                                                                text-align="start"
                                                                text-decoration-line="none"
                                                                text-decoration-style="solid"
                                                                text-decoration-color="rgb(0,0,0)"
                                                                text-transform="none"
                                                                text-orientation="mixed"
                                                                white-space="normal"
                                                                shape-padding="0"
                                                                isolation="auto"
                                                                mix-blend-mode="normal"
                                                                solid-color="rgb(0,0,0)"
                                                                solid-opacity="1"
                                                                vector-effect="none"
                                                            />
                                                        </g>
                                                    </svg>
                                                </div>
                                            </li>
                                        </ul>
                                        <div
                                            class="close-sub-nav collapsed"
                                            data-bs-toggle="collapse"
                                            href="#collapsesubmenu-1"
                                            role="button"
                                            aria-expanded="false"
                                            aria-controls="collapsesubmenu-1"
                                        >
                                            <svg
                                                version="1.1"
                                                id="Capa_1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                x="0px"
                                                y="0px"
                                                viewBox="0 0 512 512"
                                                style="
                                                    enable-background: new 0 0
                                                        512 512;
                                                "
                                                xml:space="preserve"
                                            >
                                                <g>
                                                    <g>
                                                        <path
                                                            d="M492,236H276V20c0-11.046-8.954-20-20-20c-11.046,0-20,8.954-20,20v216H20c-11.046,0-20,8.954-20,20s8.954,20,20,20h216			v216c0,11.046,8.954,20,20,20s20-8.954,20-20V276h216c11.046,0,20-8.954,20-20C512,244.954,503.046,236,492,236z"
                                                        />
                                                    </g>
                                                </g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                            </svg>

                                            <svg
                                                id="svg1591"
                                                height="24"
                                                viewBox="0 0 6.3499999 6.3500002"
                                                width="24"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:svg="http://www.w3.org/2000/svg"
                                            >
                                                <g
                                                    id="layer1"
                                                    transform="translate(0 -290.65)"
                                                >
                                                    <path
                                                        id="path2047"
                                                        d="m.79427278 293.56039a.2646485.2646485 0 0 0 0 .52917h4.76146822a.2646485.2646485 0 0 0 0-.52917z"
                                                        font-variant-ligatures="normal"
                                                        font-variant-position="normal"
                                                        font-variant-caps="normal"
                                                        font-variant-numeric="normal"
                                                        font-variant-alternates="normal"
                                                        font-feature-settings="normal"
                                                        text-indent="0"
                                                        text-align="start"
                                                        text-decoration-line="none"
                                                        text-decoration-style="solid"
                                                        text-decoration-color="rgb(0,0,0)"
                                                        text-transform="none"
                                                        text-orientation="mixed"
                                                        white-space="normal"
                                                        shape-padding="0"
                                                        isolation="auto"
                                                        mix-blend-mode="normal"
                                                        solid-color="rgb(0,0,0)"
                                                        solid-opacity="1"
                                                        vector-effect="none"
                                                    />
                                                </g>
                                            </svg>
                                        </div>
                                    </li>

                                    <li>
                                        <a
                                            href="services.html"
                                            class="header-nav-item"
                                            >Services</a
                                        >
                                    </li>
                                    <li>
                                        <a
                                            href="menu.html"
                                            class="header-nav-item"
                                            >Menu</a
                                        >
                                    </li>
                                    <li>
                                        <a
                                            href="about-us.html"
                                            class="header-nav-item"
                                            >About</a
                                        >
                                    </li>
                                    <li>
                                        <a
                                            href="blog.html"
                                            class="header-nav-item"
                                            >Blog</a
                                        >
                                    </li>
                                    <li>
                                        <a
                                            href="contact.html"
                                            class="header-nav-item"
                                            >Contact</a
                                        >
                                    </li>
                                    <li>
                                        <a
                                            href="booking.html"
                                            class="header-nav-item"
                                            >Book Now</a
                                        >
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
