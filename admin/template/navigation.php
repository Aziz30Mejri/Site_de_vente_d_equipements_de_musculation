<nav class="col-md-2 d-none d-md-block bg-light sidebar" style="padding-left: 10px;">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item" style="margin-bottom: 10px;">
                <a class="nav-link <?php echo ($current_page == 'home') ? 'active' : ''; ?>" href="http://localhost/ecommerce/admin/home.php">
                  <svg xmlns="http://www.w3.org/2000/svg"  style="color: black; margin-right: 8px;" width="16" height="16" fill="currentColor" class="bi bi-speedometer2" viewBox="0 0 16 16">
                    <path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4M3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.39.39 0 0 0-.029-.518z"/>
                    <path fill-rule="evenodd" d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A8 8 0 0 1 0 10m8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3"/>
                  </svg>
                  Dashboard <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item" style="margin-bottom: 10px;">
                <a class="nav-link <?php echo ($current_page == 'categories') ? 'active' : ''; ?>" href="http://localhost/ecommerce/admin/categories/liste.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-boxes" viewBox="0 0 16 16" style="color: black; margin-right: 8px;">
                  <path d="M7.752.066a.5.5 0 0 1 .496 0l3.75 2.143a.5.5 0 0 1 .252.434v3.995l3.498 2A.5.5 0 0 1 16 9.07v4.286a.5.5 0 0 1-.252.434l-3.75 2.143a.5.5 0 0 1-.496 0l-3.502-2-3.502 2.001a.5.5 0 0 1-.496 0l-3.75-2.143A.5.5 0 0 1 0 13.357V9.071a.5.5 0 0 1 .252-.434L3.75 6.638V2.643a.5.5 0 0 1 .252-.434zM4.25 7.504 1.508 9.071l2.742 1.567 2.742-1.567zM7.5 9.933l-2.75 1.571v3.134l2.75-1.571zm1 3.134 2.75 1.571v-3.134L8.5 9.933zm.508-3.996 2.742 1.567 2.742-1.567-2.742-1.567zm2.242-2.433V3.504L8.5 5.076V8.21zM7.5 8.21V5.076L4.75 3.504v3.134zM5.258 2.643 8 4.21l2.742-1.567L8 1.076zM15 9.933l-2.75 1.571v3.134L15 13.067zM3.75 14.638v-3.134L1 9.933v3.134z"/>
                </svg>
                  Catégories
                </a>
              </li>
              <li class="nav-item" style="margin-bottom: 10px;">
                <a class="nav-link <?php echo ($current_page == 'produits') ? 'active' : ''; ?>" href="http://localhost/ecommerce/admin/produits/liste.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box" viewBox="0 0 16 16" style="color: black; margin-right: 8px;">
                  <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
                </svg>  
                  Produits
                </a>
              </li>
              <li class="nav-item" style="margin-bottom: 10px;">
                <a class="nav-link <?php echo ($current_page == 'visiteurs') ? 'active' : ''; ?>" href="http://localhost/ecommerce/admin/visiteurs/liste.php">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16" style="color: black; margin-right: 8px;">
                    <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                    <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                  </svg>
                  Utilisateurs
                </a>
              </li>
              <li class="nav-item" style="margin-bottom: 10px;">
                <a class="nav-link <?php echo ($current_page == 'stocks') ? 'active' : ''; ?>" href="http://localhost/ecommerce/admin/stocks/liste.php">  
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" class="bi bi-wallet-fill" viewBox="0 0 16 16" style="color: black; margin-right: 8px;">
                  <path d="M1.5 2A1.5 1.5 0 0 0 0 3.5v2h6a.5.5 0 0 1 .5.5c0 .253.08.644.306.958.207.288.557.542 1.194.542s.987-.254 1.194-.542C9.42 6.644 9.5 6.253 9.5 6a.5.5 0 0 1 .5-.5h6v-2A1.5 1.5 0 0 0 14.5 2z" stroke="currentColor"/>
                  <path d="M16 6.5h-5.551a2.7 2.7 0 0 1-.443 1.042C9.613 8.088 8.963 8.5 8 8.5s-1.613-.412-2.006-.958A2.7 2.7 0 0 1 5.551 6.5H0v6A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5z" stroke="currentColor"/>
                </svg>
                  Stocks
                </a>
              </li>
              <li class="nav-item" style="margin-bottom: 10px;">
                <a class="nav-link <?php echo ($current_page == 'commandes') ? 'active' : ''; ?>" href="http://localhost/ecommerce/admin/commandes/liste.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-basket3" viewBox="0 0 16 16" style="color: black; margin-right: 8px;">
                  <path d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15.5a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 .5 6h1.717L5.07 1.243a.5.5 0 0 1 .686-.172zM3.394 15l-1.48-6h-.97l1.525 6.426a.75.75 0 0 0 .729.574h9.606a.75.75 0 0 0 .73-.574L15.056 9h-.972l-1.479 6z"/>
                </svg>
                  Paniers
                </a>
              </li>
              <!--  <li class="nav-item" style="margin-bottom: 10px;">
                <a class="nav-link <?php echo ($current_page == 'rapports') ? 'active' : ''; ?>" href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" style="color: black; margin-right: 8px;" width="16" height="16" fill="currentColor" class="bi bi-graph-up" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M0 0h1v15h15v1H0zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07"/>
                  </svg>
                  Rapports
                </a>
              </li> -->
              <li class="nav-item" style="margin-bottom: 10px;">
                <a class="nav-link <?php echo ($current_page == 'profile') ? 'active' : ''; ?>" href="http://localhost/ecommerce/admin/profile.php">
                <svg xmlns="http://www.w3.org/2000/svg" style="color: black; margin-right: 8px;" width="16" height="16" fill="none" stroke="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                  <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6" stroke="currentColor"/>
                  <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1z" stroke="currentColor"/>
                  <path d="M11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5" stroke="currentColor"/>
                  <path d="M11.5 6a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4z" stroke="currentColor"/>
                  <path d="M13.5 9a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z" stroke="currentColor"/>
                  <path d="M13.5 12a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z" stroke="currentColor"/>
                </svg>
                  Mon Profile
                </a>
              </li>
              <li class="nav-item" style="margin-top: 280px;">
              <a class="nav-link" href="../deconnexion.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-closed" viewBox="0 0 16 16">
                <path d="M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3zm1 13h8V2H4z"/>
                <path d="M9 9a1 1 0 1 0 2 0 1 1 0 0 0-2 0"/>
              </svg>
                  Déconnexion
                </a>
              </li>
            </ul>
          </div>
</nav>