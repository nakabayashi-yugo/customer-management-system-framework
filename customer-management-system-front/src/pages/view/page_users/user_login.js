import { useEffect, useState, useRef } from 'react';
import { useNavigate } from 'react-router-dom';

import { dtoUsersLogin } from "./../../dto/users/dto_users_login.ts";

import { errorAlert } from "./../error_alert.js";

function UserLoginPage() {
    const [username, setUsername] = useState('');
    const [password, setPassword] = useState('');
    const navigate = useNavigate();
    const login_button_ref = useRef(null);

    const handleLogin = async () => {
        // ここでAPI叩く処理を書く
        try {
            const api_url = "http://localhost/nakabayashi_system_training/cms_framework/customer-management-system-back/public/api/users/login";
            const send_data = new dtoUsersLogin({
                user_name: username,
                passwd: password
            });
            const response_api = await fetch(api_url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(send_data),
                credentials: 'include',
            });
            if (!response_api.ok) {
                throw new Error("API失敗：" + response_api.status);
            }
            const result = await response_api.json();
            if(result.success == true)
            {
                alert("ログイン成功");
                navigate('/cust_top');
            }
            else
            {
                errorAlert(result.errors);
            }
        } catch(error) {
            console.error("ログイン失敗：", error);
        }

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
                        <button className="entry-button button" ref={login_button_ref} onClick={handleLogin}>ログイン</button>
                    </div>

                    <div className="content-return">
                        <button className="return-button button" onClick={() => navigate('/')}>戻る</button>
                    </div>
                </div>
        </div>
    );
}

export default UserLoginPage;
