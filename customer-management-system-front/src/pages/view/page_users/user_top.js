import { Link } from 'react-router-dom';

function userTopPage()
{
    return (
    <div className="main-wrapper">
        <div className="main-header">
            <h1 className="main-title">ようこそ！</h1>
        </div>

        <div className="main-content">
            <div className="content-link">
                <div className="top-link-box">
                    <Link className="top-jump-list link" to="/user_login">ログイン</Link>
                    <Link className="top-jump-entry link" to="/user_entry">新規登録</Link>
                </div>
            </div>
        </div>
    </div>
    );
}

export default userTopPage;