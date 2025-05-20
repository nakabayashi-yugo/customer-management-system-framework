// import logo from './logo.svg';
// import './App.css';

// function App() {
//   return (
//     <div className="App">
//       <header className="App-header">
//         <img src={logo} className="App-logo" alt="logo" />
//         <p>
//           Edit <code>src/App.js</code> and save to reload.
//         </p>
//         <a
//           className="App-link"
//           href="https://reactjs.org"
//           target="_blank"
//           rel="noopener noreferrer"
//         >
//           Learn React
//         </a>
//       </header>
//     </div>
//   );
// }

// export default App;

import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import UserTopPage from './pages/view/page_users/user_top';
import UserLoginPage from './pages/view/page_users/user_login';
import UserEntryPage from './pages/view/page_users/user_entry';
import CustTopPage from './pages/view/page_cms/customers/customer_top';
import CustListPage from './pages/view/page_cms/customers/customer_list';
import CustEntryPage from './pages/view/page_cms/customers/customer_entry';
import CustEditPage from './pages/view/page_cms/customers/customer_edit';
import "./pages/view/css/page_style.css";
import "./pages/view/css/modal_style.css";

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<UserTopPage />} />
        <Route path="/user_login" element={<UserLoginPage />} />
        <Route path="/user_entry" element={<UserEntryPage />} />
        <Route path="/cust_top" element={<CustTopPage />} />
        <Route path="/cust_list" element={<CustListPage />} />
        <Route path="/cust_entry" element={<CustEntryPage />} />
        <Route path="/cust_edit/:cust_id" element={<CustEditPage />} />
      </Routes>
    </Router>
  );
}

export default App;
