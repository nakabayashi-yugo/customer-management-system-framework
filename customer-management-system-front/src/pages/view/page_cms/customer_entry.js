import { useState } from 'react';
import { useNavigate } from 'react-router-dom';

function CustomerEntryPage() {
  const navigate = useNavigate();

  const [name, setName] = useState('');
  const [nameKana, setNameKana] = useState('');
  const [mailAddress, setMailAddress] = useState('');
  const [phoneNumber, setPhoneNumber] = useState('');
  const [sex, setSex] = useState('男性');
  const [bornDate, setBornDate] = useState('');
  const [company, setCompany] = useState('');

  // ここにまとめる
  const handleRegister = () => {
    console.log('登録処理', { name, nameKana, mailAddress, phoneNumber, sex, bornDate, company });
  };

  const handleCompanyListOpen = () => {
    console.log('モーダル開く');
  };

  const handleBackToList = () => {
    navigate('/cust_list');
  };

  return (
    <div className="main-wrapper">
      <div className="main-header">
        <h1 className="main-title">新規顧客登録</h1>
      </div>

      <div className="main-content">
        <h1 className="content-title">顧客情報入力</h1>

        <div className="entry-input">
          <table className="entry-input-table">
            <tbody>
                <tr className="entry-input-name">
                    <th width="100px">顧客名</th>
                    <td className="entry-input-form" id="entry-input-name" width="100px">
                        <input type="text" placeholder="佐藤　次郎" value={name} onChange={(e) => setName(e.target.value)} />
                    </td>
                </tr>
                <tr className="entry-input-name-kana">
                    <th width="100px">顧客名カナ</th>
                    <td className="entry-input-form" id="entry-input-name-kana" width="100px">
                        <input type="text" placeholder="サトウ　ジロウ" value={nameKana} onChange={(e) => setNameKana(e.target.value)} />
                    </td>
                </tr>
                <tr className="entry-input-mail-address">
                    <th width="100px">メールアドレス</th>
                    <td className="entry-input-form" id="entry-input-mail-address" width="100px">
                        <input type="text" placeholder="jirou@gmail.com" value={mailAddress} onChange={(e) => setMailAddress(e.target.value)} />
                    </td>
                </tr>
                <tr className="entry-input-phone-number">
                    <th width="100px">電話番号</th>
                    <td className="entry-input-form" id="entry-input-phone-number" width="100px">
                        <input type="text" placeholder="090-0000-0000" value={phoneNumber} onChange={(e) => setPhoneNumber(e.target.value)} />
                    </td>
                </tr>
                <tr className="entry-input-sex">
                    <th width="100px">性別</th>
                    <td className="entry-input-form" id="entry-input-sex" width="100px">
                        <select value={sex} onChange={(e) => setSex(e.target.value)}>
                        <option value="男性">男性</option>
                        <option value="女性">女性</option>
                        <option value="その他">その他</option>
                        </select>
                    </td>
                </tr>
                <tr className="entry-input-born-date">
                    <th width="100px">生年月日</th>
                    <td className="entry-input-form" id="entry-input-born-date" width="100px">
                        <input type="date" value={bornDate} onChange={(e) => setBornDate(e.target.value)} />
                    </td>
                </tr>
                <tr className="entry-input-company">
                    <th width="100px">所属会社</th>
                    <td className="entry-input-form" id="entry-input-company" width="100px">
                        <select id="search_company" value={company} onChange={(e) => setCompany(e.target.value)}>
                        <option value="">会社を選択</option>
                        </select>
                    </td>
                </tr>
            </tbody>
          </table>

          <div className="content-company">
            <button className="company-button button" type="button" onClick={handleCompanyListOpen}>会社一覧</button>
          </div>
        </div>

        <div className="content-entry">
          <button className="entry-button button" id="entry-button-action" type="button" onClick={handleRegister}>登録</button>
        </div>

        <div className="content-return">
          <button className="return-button button" id="return-button" type="button" onClick={handleBackToList}>一覧へ</button>
        </div>
      </div>
    </div>
  );
}

export default CustomerEntryPage;
