<div class="side-content-wrap">
    <div
       class="sidebar-left open rtl-ps-none"
       data-perfect-scrollbar=""
       data-suppress-scroll-x="true"
       >
       <ul class="navigation-left">
          <li class="nav-item {{ $menu == "dashboard" ? 'active' : ''}}">
            <a class="nav-item-hold" href="{{ route('dashboard') }}" >
               <i class="nav-icon i-Bar-Chart"></i ><span class="nav-text">Dashboard</span>
            </a>
             <div class="triangle"></div>
          </li>
          <li class="nav-item" data-item="uikits">
             <a class="nav-item-hold" href="#"
                ><i class="nav-icon i-Library"></i
                ><span class="nav-text">Données</span></a
                >
             <div class="triangle"></div>
          </li>
          <li class="nav-item" data-item="charts">
            <a class="nav-item-hold" href="#"
               ><i class="nav-icon i-File-Clipboard-File--Text"></i
               ><span class="nav-text">Livres</span></a
               >
            <div class="triangle"></div>
         </li>
          <li class="nav-item {{ $menu == "utilisateur" ? 'active' : ''}}">
             <a class="nav-item-hold" href="{{ route('utilisateur.index') }}"
                ><i class="nav-icon i-Administrator"></i
                ><span class="nav-text">Utilisateurs</span></a
                >
             <div class="triangle"></div>
          </li>
          <li class="nav-item {{ $menu == "publicites" ? 'active' : ''}}">
             <a class="nav-item-hold" href="{{ route('publicite.index') }}"
                ><i class="nav-icon i-Administrator"></i
                ><span class="nav-text">Publicités</span></a
                >
             <div class="triangle"></div>
          </li>
          <li class="nav-item {{ $menu == "parole_fortes" ? 'active' : ''}}">
             <a class="nav-item-hold" href="{{ route('parole-forte.index') }}"
                ><i class="nav-icon i-Administrator"></i
                ><span class="nav-text">Paroles fortes</span></a
                >
             <div class="triangle"></div>
          </li>
          <li class="nav-item {{ $menu == "historique_achat_jeton" ? 'active' : ''}}" data-item="widgets">
             <a class="nav-item-hold" href="#"
                ><i class="nav-icon i-Computer-Secure"></i
                ><span class="nav-text">Transactions</span></a
                >
             <div class="triangle"></div>
          </li>

       </ul>
    </div>
    <div
       class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar=""data-suppress-scroll-x="true">
       <!-- Submenu Dashboards-->

       <ul class="childNav" data-parent="forms">
          <li class="nav-item">
             <a href="form.basic.html"
                ><i class="nav-icon i-File-Clipboard-Text--Image"></i
                ><span class="item-name">Basic Elements</span></a
                >
          </li>
          <li class="nav-item">
             <a href="form.layouts.html"
                ><i class="nav-icon i-Split-Vertical"></i
                ><span class="item-name">Form Layouts</span></a
                >
          </li>
          <li class="nav-item">
             <a href="form.input.group.html"
                ><i class="nav-icon i-Receipt-4"></i
                ><span class="item-name">Input Groups</span></a
                >
          </li>
          <li class="nav-item">
             <a href="form.validation.html"
                ><i class="nav-icon i-Close-Window"></i
                ><span class="item-name">Form Validation</span></a
                >
          </li>
          <li class="nav-item">
             <a href="smart.wizard.html"
                ><i class="nav-icon i-Width-Window"></i
                ><span class="item-name">Smart Wizard</span></a
                >
          </li>
          <li class="nav-item">
             <a href="tag.input.html"
                ><i class="nav-icon i-Tag-2"></i
                ><span class="item-name">Tag Input</span></a
                >
          </li>
          <li class="nav-item">
             <a href="editor.html"
                ><i class="nav-icon i-Pen-2"></i
                ><span class="item-name">Rich Editor</span></a
                >
          </li>
       </ul>
       <ul class="childNav" data-parent="apps">
          <li class="nav-item">
             <a href="invoice.html"
                ><i class="nav-icon i-Add-File"></i
                ><span class="item-name">Invoice</span></a
                >
          </li>
          <li class="nav-item">
             <a href="inbox.html"
                ><i class="nav-icon i-Email"></i
                ><span class="item-name">Inbox</span></a
                >
          </li>
          <li class="nav-item">
             <a href="chat.html"
                ><i class="nav-icon i-Speach-Bubble-3"></i
                ><span class="item-name">Chat</span></a
                >
          </li>
       </ul>
       <ul class="childNav" data-parent="widgets">
          <li class="nav-item">
             <a href="{{ route('historique-achat.talent') }}"
                ><i class="nav-icon i-Receipt-4"></i
                ><span class="item-name">Historique achat de talents</span></a
                >
          </li>
          <li class="nav-item">
             <a href="{{ route('historique.abonnement') }}"
                ><i class="nav-icon i-Receipt-4"></i
                ><span class="item-name">Historique des abonnements</span></a
                >
          </li>
           <li class="nav-item">
             <a href="{{ route('achat.livre') }}">
               <i class="nav-icon i-Receipt-4"></i><span class="item-name">Historique des achats de livre</span></a>
          </li>
       </ul>
       <!-- chartjs-->
       <ul class="childNav" data-parent="charts">
          <li class="nav-item {{ $menu == "livres" ? 'active' : ''}}">
             <a href="{{ route('livre.index') }}"
                ><i class="nav-icon i-File-Clipboard-Text--Image"></i
                ><span class="item-name">Les livres enregistré</span></a
                >
          </li>
          <li class="nav-item">
             <a href="{{ route('livre.achetes') }}"
                ><i class="nav-icon i-File-Clipboard-Text--Image"></i
                ><span class="item-name">Les livres achetés</span></a
                >
          </li>
       </ul>
       <ul class="childNav" data-parent="uikits">
          <li class="nav-item {{ $menu == "auteur" ? 'active' : ''}}">
             <a href="{{ route('auteur.index') }}"><i class="nav-icon i-Bell1"></i>
               <span class="item-name">Auteurs</span>
            </a>
          </li>
          <li class="nav-item {{ $menu == "categorie_livre" ? 'active' : ''}}">
             <a href="{{ route('categorie-livre.index') }}"
                ><i class="nav-icon i-Split-Horizontal-2-Window"></i
                ><span class="item-name">Catégorie de livres</span></a
                >
          </li>
          <li class="nav-item {{ $menu == "type_publication" ? 'active' : ''}}">
             <a href="{{ route('type-de-publication.index') }}"
                ><i class="nav-icon i-Medal-2"></i
                ><span class="item-name">Type de publications</span></a
                >
          </li>
          <li class="nav-item {{ $menu == "pays" ? 'active' : ''}}">
             <a href="{{ route('pays.index') }}"
                ><i class="nav-icon i-Cursor-Click"></i
                ><span class="item-name">Pays</span></a
                >
          </li>
          <li class="nav-item {{ $menu == "devise" ? 'active' : ''}}">
             <a href="{{ route('devise.index') }}"
                ><i class="nav-icon i-Line-Chart-2"></i
                ><span class="item-name">Devises</span></a
                >
          </li>
          <li class="nav-item {{ $menu == "langue" ? 'active' : ''}}">
             <a href="{{ route('langue.index') }}"
                ><i class="nav-icon i-ID-Card"></i
                ><span class="item-name">Langues</span></a
                >
          </li>
          <li class="nav-item {{ $menu == "editeur" ? 'active' : ''}}">
             <a href="{{ route('editeur.index') }}"
                ><i class="nav-icon i-Video-Photographer"></i
                ><span class="item-name">Éditeurs</span></a
                >
          </li>
          <li class="nav-item {{ $menu == "forfait" ? 'active' : ''}}">
             <a href="{{ route('forfait.index') }}"
                ><i class="nav-icon i-Arrow-Next"></i
                ><span class="item-name">Forfaits</span></a
                >
          </li>
          <li class="nav-item {{ $menu == "jeton" ? 'active' : ''}}">
             <a href="{{ route('jeton.index') }}"
                ><i class="nav-icon i-Receipt-4"></i
                ><span class="item-name">Pièces</span></a
                >
          </li>
       </ul>
       <ul class="childNav" data-parent="sessions">
          <li class="nav-item">
             <a href="../sessions/signin.html"
                ><i class="nav-icon i-Checked-User"></i
                ><span class="item-name">Sign in</span></a
                >
          </li>
          <li class="nav-item">
             <a href="../sessions/signup.html"
                ><i class="nav-icon i-Add-User"></i
                ><span class="item-name">Sign up</span></a
                >
          </li>
          <li class="nav-item">
             <a href="../sessions/forgot.html"
                ><i class="nav-icon i-Find-User"></i
                ><span class="item-name">Forgot</span></a
                >
          </li>
       </ul>
       <ul class="childNav" data-parent="others">
          <li class="nav-item">
             <a href="../sessions/not-found.html"
                ><i class="nav-icon i-Error-404-Window"></i
                ><span class="item-name">Not Found</span></a
                >
          </li>
          <li class="nav-item">
             <a href="user.profile.html"
                ><i class="nav-icon i-Male"></i
                ><span class="item-name">User Profile</span></a
                >
          </li>
          <li class="nav-item">
             <a class="open" href="blank.html"
                ><i class="nav-icon i-File-Horizontal"></i
                ><span class="item-name">Blank Page</span></a
                >
          </li>
       </ul>
    </div>
    <div class="sidebar-overlay"></div>
 </div>
 <!-- =============== Left side End ================-->
 <div class="main-content-wrap sidenav-open d-flex flex-column">
    <!-- ============ Body content start ============= -->
    <div class="main-content">
