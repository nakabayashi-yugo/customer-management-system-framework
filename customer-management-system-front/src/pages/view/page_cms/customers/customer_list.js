import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { dtoCustomersList } from "./../../../dto/customers/dto_customers_list.ts";
import { dtoCustomersCount } from "./../../../dto/customers/dto_customers_count.ts";
import { dtoCustomersDelete } from "./../../../dto/customers/dto_customers_delete.ts";
import { onCount } from "./other/customer_service.js";
import { getCompanies } from "./../companies/other/companies_service.js";

function CustomerListPage() {
    const navigate = useNavigate();

    //検索項目
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

    //ページャー機能関連
    const [nowPage, setNowPage] = useState(1);
    const [maxPage, setMaxPage] = useState(1);  // APIから取得する想定
    const [dispNum, setDispNum] = useState(10);
    const [pagerLinks, setPagerLinks] = useState([]);

    //一覧データ
    const [listData, setListData] = useState([]);
    //会社一覧データ
    const [companiesData, setCompaniesData] = useState([]);

    const [takeListData, setTakeListData] = useState(new dtoCustomersList());

    useEffect(() => {
        const fetchCompanies = async () => {
            setCompaniesData(await getCompanies());
        }
        fetchCompanies();
        onSearch();
    }, []);  // ← 空配列にすると初回だけ実行される

    useEffect(() => {
        onList();
        updatePager(takeListData.page_id || 1, takeListData);
    }, [takeListData]);

    const onSearch = () => {
        const newData = {
            ...takeListData,
            search_data: {
                cust_name: name,
                cust_name_kana: nameKana,
                sex: sex,
                born_year: bornYear,
                born_month: bornMonth,
                born_date: bornDate,
                company_id: company
            }
        };
        setTakeListData(newData);
    };
    const onList = async () => {
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
            if (!response_api.ok) {
                throw new Error("API失敗：" + response_api.status);
            }
            const result = await response_api.json();
            if(result.data && Array.isArray(result.data)) 
            {
                setListData(result.data);
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
    }
    const onNumChange = (_num) => {
        setDispNum(Number(_num));  // ← 数値化して保存

        const newData = {
            ...takeListData,
            disp_num: Number(_num),
        };
        setDispNum(_num);
        setTakeListData(newData);
    };
    const onPager = async (page) => {
        setNowPage(page);
        const newData = {
            ...takeListData,
            page_id: page,
        }
        setTakeListData(newData);
        updatePager(page, newData);
    };
    const updatePager = async (page, data = takeListData) => {
        let count_data = new dtoCustomersCount(data.search_data);
        const custNum = await onCount(count_data);
        const newMaxPage = Math.ceil(custNum / dispNum);
        setMaxPage(newMaxPage);

        const pageLinks = generatePagination(page, newMaxPage); // ← page を直接使う
        setPagerLinks(pageLinks);
    }
    const renderPager = () => {
        return (
            <div className="list-pager">
                {pagerLinks.map((pageLink, index) => (
                    typeof pageLink === "number" ? (
                        pageLink === nowPage ? (
                            <p key={index} className="list-pager-link">{pageLink}</p>
                        ) : (
                            <a key={index} href="#" onClick={(e) => { e.preventDefault(); onPager(pageLink); }}>
                                <p className="list-pager-link">{pageLink}</p>
                            </a>
                        )
                    ) : (
                        <p key={index} className="list-pager-link">{pageLink}</p>
                    )
                ))}
            </div>
        );
    };
    function generatePagination(nowPage, maxPage) {
        const pageLinks = [];
        const neighbor_disp_num = 2;            //表示されてるページの何ページ前後までページャーとして表示するか

        if (nowPage > neighbor_disp_num + 1) {     //表示されているページが最初のページからneighbor_disp_num分離れていたら
            pageLinks.push(1);                     //最初のページ追加
            if (nowPage > neighbor_disp_num + 2) { //表示されているページが最初のページからneighbor_disp_num分に加えひとつでも多くページを離れていたら
                pageLinks.push("...");                      //...追加
            }         
        }

        //表示されているページから前後neighbor_disp_num分の値でループ
        for (let i = nowPage - neighbor_disp_num; i <= nowPage + neighbor_disp_num; i++) {
            if (i >= 1 && i < maxPage) {           //iがページャーの範囲から抜けてないかチェック
                pageLinks.push(i);                          //抜けてなかったら追加
            }
        }

        if (nowPage < maxPage - neighbor_disp_num) {        //表示されているページが最後のページからneighbor_disp_num前のページより離れていたら
            if (nowPage < maxPage - neighbor_disp_num - 1) {    //表示されているページが最後のページからneighbor_disp_num分に加えひとつでも多くページを離れていたら
                pageLinks.push("...");                      //...追加
            }
        }
        pageLinks.push(maxPage);                        //最後のページ追加

        return pageLinks;
    }

    const onDelete = async (cust_id) => {
        if (!window.confirm("本当に削除しますか？")) return;

        const api_url = "http://localhost/nakabayashi_system_training/cms_framework/customer-management-system-back/public/api/customers/delete";
        try {
            const send_data = new dtoCustomersDelete();
            send_data.cust_id = cust_id;

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
            if (result.success) {
                onList();  // 削除成功後に一覧更新
            } else {
                alert("削除に失敗しました");
            }
        } catch (error) {
            console.error("削除失敗", error);
            alert("削除に失敗しました");
        }
    };

    const handleToTop = () => {
        navigate('/cust_top');
    };
    const handleToEntry = () => {
        navigate("/cust_entry");
    }
    const handleToEdit = (cust_id) => {
        navigate(`/cust_edit/${cust_id}`);
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
                            <option value="">全て</option>
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

                        <select className="search-company" onChange={(e) => setCompany(e.target.value)}>
                            <option value="">全て</option>
                            {Array.isArray(companiesData) && companiesData.map((companyItem) => (
                                <option key={companyItem.company_id} value={companyItem.company_id}>
                                    {companyItem.company_name}
                                </option>
                            ))}
                        </select>

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
                            {listData.map((customer, index) => (
                                <tr key={index}>
                                    <td>{customer.cust_id}</td>
                                    <td>{customer.cust_name}</td>
                                    <td>{customer.cust_name_kana}</td>
                                    <td>{customer.mail_address}</td>
                                    <td>{customer.phone_number}</td>
                                    <td>{customer.sex}</td>
                                    <td>{customer.company_name}</td>
                                    <td>{customer.insert_at}</td>
                                    <td>{customer.update_at}</td>
                                    <td>
                                        <button className="list-costomers-table-edit-button edit-button button" onClick={() => handleToEdit(customer.cust_id)}>編集</button>
                                    </td>
                                    <td>
                                        <button className="list-customers-table-delete-button delete-button button" onClick={() => onDelete(customer.cust_id)}>削除</button>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                    </div>

                    <div className="list-pager" id="list-pager">
                    {renderPager()}
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
