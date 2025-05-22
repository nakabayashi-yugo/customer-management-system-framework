import { useState, useEffect, useRef } from 'react';

import { getCompanies } from "./../other/companies_service";
import { dtoCompaniesDelete } from "./../../../../dto/companies/dto_companies_delete.ts";

import { errorAlert } from "./../../../error_alert.js";

export default function CompaniesListModal({ isOpen, onClose, onEntry, onEdit }) {
  const [listData, setListData] = useState([]);
  const prevIsOpen = useRef(false); // 前回の isOpen を保持

  useEffect(() => {
    // 前が false で、今が true（つまり開かれた瞬間）
    if (!prevIsOpen.current && isOpen) {
      onList();
    }
    prevIsOpen.current = isOpen; // 現在の状態を保存
  }, [isOpen]);

  const onList = async () => {
      setListData(await getCompanies());
  }

  const onDelete = async (company_id) => {
    if (!window.confirm("本当に削除しますか？")) return;
    
    const api_url = "http://localhost/nakabayashi_system_training/cms_framework/customer-management-system-back/public/api/companies/delete";
    try {
      const send_data = new dtoCompaniesDelete();
      send_data.company_id = company_id;

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
          alert("会社の削除に成功しました。");
          onList();
      }
      else
      {
        errorAlert(result.errors);
      }
    } catch(error) {
        console.error("削除失敗", error);
    }
  }

  if (!isOpen) return null;

  return (
    <div className="modal-companies-list modal" id="modal-company-list">
      <div className="modal-main-wrappar">
        <div className="modal-main-header">
          <span
            className="modal-close-button"
            onClick={onClose}
          >
            &times;
          </span>
          <div className="modal-main-title">
            <h2>所属会社一覧</h2>
          </div>
        </div>

        <div className="modal-main-content">
          <div className="modal-content-entry">
            <button
              className="modal-entry-button entry-button button"
              onClick={onEntry}
            >
              会社登録
            </button>
          </div>

          <div className="modal-content-list">
            <div className="modal-list-companies">
              <table
                className="modal-list-companies-table"
                id="list-customers-table"
                bgcolor="#a9a9a9"
              >
                <thead>
                  <tr className="modal-list-companies-table-header" bgcolor="#D3D3D3">
                    <th width="50px">会社ID</th>
                    <th width="300px">会社名</th>
                    <th width="50px">編集</th>
                    <th width="50px">削除</th>
                  </tr>
                </thead>
                <tbody
                  className="modal-list-companies-table-body"
                  id="modal-list-companies-table-body"
                  bgcolor="white"
                >
                  {listData.map((company, index) => (
                      <tr key={index}>
                          <td>{company.company_id}</td>
                          <td>{company.company_name}</td>
                          <td>
                                <button className="modal-list-company-table-edit-button edit-button button" onClick={() => onEdit(company.company_id)}>編集</button>
                          </td>
                          <td>
                              <button className="modal-list-company-table-delete-button delete-button button" onClick={() => onDelete(company.company_id)}>削除</button>
                          </td>
                      </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>

          <div className="modal-content-return">
            <button
              className="modal-return-button button"
              onClick={onClose}
            >
              戻る
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}
