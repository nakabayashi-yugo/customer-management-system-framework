import { Link } from 'react-router-dom';

function customerTopPage()
{
    return (
    <div className="main-wrapper">
        <div className="main-header">
            <h1 className="main-title">顧客管理システム</h1>
        </div>

        <div className="main-content">
            <div className="content-link">
                <div className="top-link-box">
                    <Link className="top-jump-list link" to="/cust_list">顧客情報一覧</Link>
                    <Link className="top-jump-entry link" to="/cust_entry">顧客情報登録</Link>
                </div>
            </div>
        </div>
    </div>
    );
}

export default customerTopPage;