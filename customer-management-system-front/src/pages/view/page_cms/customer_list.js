import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { dtoCustomersList } from "./../../dto/customers/dto_customers_list.ts";

function CustomerListPage() {
    const navigate = useNavigate();

    const [name, setName] = useState('');
    const [nameKana, setNameKana] = useState('');
    const [sex, setSex] = useState('');
    const [bornYear, setBornYear] = useState('');
    const [bornMonth, setBornMonth] = useState('');
    const [bornDate, setBornDate] = useState('');
    const [company, setCompany] = useState('');

    //誕生日付の範囲
    const year_range = 100;
    const current_year = new Date().getFullYear();
    const year_list = Array.from({length: year_range}, (_, i) => current_year - i);
    const month_list = Array.from({length: 12}, (_, i) => i + 1);
    const date_list = Array.from({length: 31}, (_, i) => i + 1);

    //一覧データ
    const list_data = [];

    const [takeListData, setTakeListData] = useState({
        search_data: {},
        sort_data: {},
    });

    useEffect(() => {
        console.log("画面きたから初回だけ検索しとくね");
        onDto();
        onSearch();
        onSort("cust_id", "昇順");  // 必要なら
    }, []);  // ← 空配列にすると初回だけ実行される

    // 変更されるたびにonListが走る
    useEffect(() => {
        onList();
    }, [takeListData]);

    const onDto = () => {
        //dtoからデータ取得
        //take_list_dataにいれる
        setTakeListData(new dtoCustomersList());
        console.log("DTO初期化", takeListData);
    }
    const onSearch = () => {
        setTakeListData(prev => ({
            ...prev,
            search_data: {
                cust_name: name,
                cust_name_kana: nameKana,
                sex: sex,
                born_year: bornYear,
                born_month: bornMonth,
                born_date: bornDate,
                company_id: company
            }
        }));
        console.log("検索します", name, nameKana, sex, bornYear, bornMonth, bornDate, company);
    };
    const onList = async () => {
        console.log("リスト出すぞー", takeListData);
        try {
            const api_url = "http://localhost/nakabayashi_system_training/cms_framework/customer-management-system-back/public/api/customers/list";
            const response_api = await fetch(api_url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(takeListData),
                credentials: 'include',
            });
            const result = await response_api.json();
            console.log(result);
            if(result.success == true)
            {
                
            }
            else
            {
                throw new Error("なんでかは知らないよ");
            }
        } catch(error) {
            console.error("一覧取得失敗", error);
        }
    }
    const onSort = (_key = null, _order = null) => {
        setTakeListData(prev => ({
            ...prev,
            sort_data: {
                sort_key: _key || prev.sort_data.sort_key,
                sort_order: _order || prev.sort_data.sort_order
            }
        }));
        console.log("ソートするぞー", _key, _order);
    }
    const onNumChange = (_num) => {
        setTakeListData(prev => ({
            ...prev,
            disp_num: _num,
        }));
        console.log("表示件数かえるぞー", _num);
    }

    const handleToTop = () => {
        navigate('/cust_top');
    };
    const handleToEntry = () => {
        navigate("/cust_entry");
    }  

    return (
        <div className="main-wrapper">
            <div className="main-header">
            <h1 className="main-title">顧客情報一覧</h1>
            </div>

            <div className="main-content">
                <div className="content-search">
                    <div className="search-input">
                        <div className="search-customer-name">
                            <input
                                type="text"
                                placeholder="顧客名カナ"
                                value={nameKana}
                                onChange={(e) => setNameKana(e.target.value)}
                            />
                            <input
                                type="text"
                                placeholder="顧客名"
                                value={name}
                                onChange={(e) => setName(e.target.value)}
                            />
                        </div>

                        <select className="search-sex" onChange={(e) => setSex(e.target.value)}>
                            <option value="全て">全て</option>
                            <option value="男性">男性</option>
                            <option value="女性">女性</option>
                            <option value="その他">その他</option>
                        </select>

                        <div className="search-born-date-box">
                            <select className="search-born-year" onChange={(e) => setBornYear(e.target.value)}>
                            <option value="">誕生年</option>
                            {
                                year_list.map((year) => (
                                    <option key={year} value={year}>
                                        {year}
                                    </option>
                                ))
                            }
                            </select>
                            <select className="search-born-month" onChange={(e) => setBornMonth(e.target.value)}>
                            <option value="">誕生月</option>
                            {
                                month_list.map((month) => (
                                    <option key={month} value={month}>
                                        {month}
                                    </option>
                                ))
                            }
                            </select>
                            <select className="search-born-date" onChange={(e) => setBornDate(e.target.value)}>
                            <option value="">誕生日</option>
                            {
                                date_list.map((date) => (
                                    <option key={date} value={date}>
                                        {date}
                                    </option>
                                ))
                            }
                            </select>
                        </div>

                        <select className="search-company" onChange={(e) => setCompany(e.target.value)}></select>

                        <button className="search-button button" onClick={onSearch}>検索</button>
                        <button className="reset-button button" id="reset">リセット</button>
                    </div>
                </div>

                <div className="content-list">
                    <div className="list-entry-button">
                        <button className="entry-button button" type="button" onClick={handleToEntry}>顧客登録</button>
                    </div>

                    <div className="list-control">
                    <div className="list-disp-num-box">
                        <p className="list-disp-num-header">表示件数：</p>
                        <select className="list-disp-num" onChange={(e) => onNumChange(e.target.value)}>
                        <option value="10">10件</option>
                        <option value="20">20件</option>
                        </select>
                    </div>

                    <div className="list-sort-box">
                        <select className="list-sort-key" onChange={(e) => onSort(e.target.value, null)}>
                        <option value="cust_id">顧客ID</option>
                        <option value="cust_name">顧客名</option>
                        <option value="cust_name_kana">顧客名カナ</option>
                        <option value="mail_address">メールアドレス</option>
                        <option value="phone_number">電話番号</option>
                        <option value="sex">性別</option>
                        <option value="company_id">所属会社</option>
                        <option value="born_date">生年月日</option>
                        <option value="insert_at">新規登録日時</option>
                        <option value="update_at">最終更新日時</option>
                        </select>
                        <select className="list-sort" onChange={(e) => onSort(null, e.target.value)}>
                        <option value="昇順">昇順</option>
                        <option value="降順">降順</option>
                        </select>
                    </div>
                    </div>

                    <div className="list-customers">
                    <table className="list-customers-table" id="list-customers-table">
                        <thead>
                        <tr className="list-customers-table-item-name">
                            <th width="50px">顧客ID</th>
                            <th width="150px">顧客名</th>
                            <th width="150px">顧客名カナ</th>
                            <th width="200px">メールアドレス</th>
                            <th width="150px">電話番号</th>
                            <th width="50px">性別</th>
                            <th width="200px">所属会社</th>
                            <th width="100px">新規登録日時</th>
                            <th width="100px">最終更新日時</th>
                            <th width="50px">編集</th>
                            <th width="50px">削除</th>
                        </tr>
                        </thead>
                        <tbody className="list-customers-table-item" id="list-customers-table-item">
                        {/* データをmapで展開 */}
                        </tbody>
                    </table>
                    </div>

                    <div className="list-pager" id="list-pager">
                    {/* ページャー機能 */}
                    </div>
                </div>

                <div className="content-return">
                    <button className="return-button button" onClick={handleToTop}>戻る</button>
                </div>
            </div>
        </div>
    );
}

export default CustomerListPage;
