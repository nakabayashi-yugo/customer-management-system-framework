import { useEffect, useState, useRef } from 'react';
import { useNavigate } from 'react-router-dom';

function UserLoginPage() {
    const [username, setUsername] = useState('');
    const [password, setPassword] = useState('');
    const navigate = useNavigate();
    const login_button_ref = useRef(null);

    const handleLogin = () => {
        console.log('ログイン実行', username, password);
        // ここでAPI叩く処理を書く
    };

    useEffect(() => {
        const handleKeyDown = (event) => {
            if(event.key === "Enter")
            {
                event.preventDefault();
                login_button_ref.current?.click();
            }
        }
        document.addEventListener('keydown', handleKeyDown);
        return () => {
        document.removeEventListener('keydown', handleKeyDown);
        };
    }, []);

    return (
        <div className="main-wrapper">
            <div className="main-header">
                <h1 className="main-title">ログイン</h1>
                    </div>

                    <div className="main-content">
                    <div className="content-user-input">
                        <table className="user-input-table">
                            <tbody>
                                <tr className="user-input-name-box" style={{ height: "24px" }}>
                                    <th className="user-input-header" width="100px">ユーザーネーム</th>
                                    <td className="user-input" id="user-input-name" width="100px">
                                        <input
                                            type="text"
                                            value={username}
                                            onChange={(e) => setUsername(e.target.value)}
                                        />
                                    </td>
                                </tr>
                                <tr className="user-input-passwd-box" style={{ height: "24px" }}>
                                    <th className="user-input-header" width="100px">パスワード</th>
                                    <td className="user-input" id="user-input-passwd" width="100px">
                                        <input
                                            type="password"
                                            value={password}
                                            onChange={(e) => setPassword(e.target.value)}
                                        />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div className="content-login">
                        <button className="entry-button button" ref={login_button_ref} onClick={handleLogin}>新規登録</button>
                    </div>

                    <div className="content-return">
                        <button className="return-button button" onClick={() => navigate('/')}>戻る</button>
                    </div>
                </div>
        </div>
    );
}

export default UserLoginPage;
